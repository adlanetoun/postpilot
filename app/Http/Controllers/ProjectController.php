<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use App\Jobs\GenerateCampaignJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Store a newly created project in storage and initiate campaign generation.
     */
    public function store(Request $request)
    {
        // SECURITY FIX 7-A: Subscription gate — free users limited to 1 project
        $user = $request->user();
        $subscription = $user->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            $existingCount = $user->projects()->count();
            if ($existingCount >= 1) {
                return redirect()->route('dashboard')
                    ->with('error', 'Free accounts are limited to 1 project. Upgrade to Pro for unlimited campaigns.');
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'website_url' => 'nullable|string|max:255',
            // HARD LIMIT: Prevents massive prompt injection payloads
            'description' => 'required|string|max:1500', 
            'target_audience' => 'required|string|max:255',
            'value_proposition' => 'nullable|string|max:500',
            'tone_of_voice' => 'nullable|string|max:255',
            'language' => 'required|string|in:English,Arabic,French,Spanish,German',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'required|string|in:linkedin,twitter,facebook',
        ]);

        // SECURITY FIX 3-A: Sanitize ALL user fields against prompt injection
        $project = $user->projects()->create([
            'name' => $this->sanitizeForLlm($validated['name']),
            'website_url' => $validated['website_url'] ?? null,
            'description' => $this->sanitizeForLlm($validated['description']),
            'target_audience' => $this->sanitizeForLlm($validated['target_audience']),
            'value_proposition' => $this->sanitizeForLlm($validated['value_proposition'] ?? ''),
            'tone_of_voice' => $this->sanitizeForLlm($validated['tone_of_voice'] ?? 'Professional'),
            'language' => $validated['language'],
            'platforms' => $validated['platforms'],
        ]);

        // Create campaign in generating status
        $campaign = $project->campaigns()->create([
            'status' => 'generating',
        ]);

        // Dispatch background campaign generation job
        GenerateCampaignJob::dispatch($campaign->id);

        return redirect()->route('dashboard')->with('success', 'Project created! We are generating your 30-day campaign.');
    }

    /**
     * Remove the specified project from storage and clean up its cached JSON files.
     */
    public function destroy(Project $project)
    {
        // SECURITY FIX 1-A: Use ProjectPolicy instead of manual if-check
        Gate::authorize('delete', $project);

        // Gather all raw LLM payload files for the project's campaigns
        $paths = $project->campaigns()
            ->whereNotNull('raw_llm_payload_path')
            ->pluck('raw_llm_payload_path')
            ->toArray();

        // Physically delete files from NVMe storage before DB cascading deletes the campaign rows
        foreach ($paths as $path) {
            if ($path) {
                // If it is stored relative to disk or absolute path
                if (file_exists($path)) {
                    @unlink($path);
                } elseif (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
        }

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project and all associated campaigns deleted successfully.');
    }

    /**
     * Sanitize user-provided text before it is interpolated into LLM prompts.
     * Strips control characters and common prompt injection patterns.
     */
    private function sanitizeForLlm(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Strip HTML tags
        $text = strip_tags($text);

        // Remove control characters (keeps newlines and tabs for readability)
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', ' ', $text);

        // Neutralize common prompt injection override patterns
        $text = preg_replace(
            '/\b(ignore|disregard|forget|override|bypass|skip)\s+(all\s+)?(previous|above|prior|earlier|system)\s+(instructions|prompts|rules|context)/i',
            '[FILTERED]',
            $text
        );

        // Neutralize "system:" or "assistant:" role injection
        $text = preg_replace('/^(system|assistant|user)\s*:/im', '[FILTERED]:', $text);

        return Str::limit($text, 1500, '');
    }
}
