<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use App\Jobs\GenerateCampaignJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // SECURITY FIX: Prevent Race Conditions using Cache Lock
        $lock = Cache::lock('project_create_user_' . $user->id, 10);
        
        try {
            $lock->block(5);

            // Project creation is free, but limited to 50 per user to prevent spam
            $existingCount = $user->projects()->count();
            if ($existingCount >= 50) {
                return redirect()->route('dashboard')
                    ->with('error', 'You have reached the maximum limit of 50 projects.');
            }

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) use ($user) {
                        if ($user->projects()->where('name', $value)->exists()) {
                            $fail('You already have a project with this name. Please choose a unique name.');
                        }
                    }
                ],
            ]);

            // Create the lightweight project wrapper
            $project = $user->projects()->create([
                'name' => $this->sanitizeForLlm($validated['name']),
            ]);

            // Redirect to the Project Dashboard to complete setup (connect socials)
            return redirect()->route('projects.show', $project->id)
                ->with('success', 'Project created! Please connect your social accounts to proceed.');
                
        } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
            return redirect()->route('dashboard')->with('error', 'System is busy processing another request. Please try again.');
        } finally {
            $lock?->release();
        }
    }

    /**
     * Display the project dashboard (Project Setup & Campaign List).
     */
    public function show(Project $project)
    {
        Gate::authorize('view', $project);
        
        $project->load(['campaigns' => function($q) { $q->latest(); }, 'socialAccounts']);
        
        $campaign = $project->campaigns->first();
        $connectedPlatforms = $project->socialAccounts->pluck('provider')->toArray();

        $state = 'A'; // No Campaign
        $posts = collect();

        if ($campaign) {
            if ($campaign->status === 'generating') {
                $state = 'B';
            } elseif ($campaign->status === 'failed_generation') {
                $state = 'FAILED';
            } elseif ($campaign->status === 'completed' || $campaign->status === 'active' || $campaign->status === 'paused') {
                $state = 'C';
                $posts = $campaign->posts;
            }
        }
        
        return view('projects.show', compact('project', 'campaign', 'state', 'posts', 'connectedPlatforms'));
    }

    /**
     * Remove the specified project from storage and clean up its cached JSON files.
     */
    public function destroy(Project $project)
    {
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

        $msg = 'Project and all associated campaigns deleted successfully.';

        return redirect()->route('dashboard')->with('success', $msg);
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
