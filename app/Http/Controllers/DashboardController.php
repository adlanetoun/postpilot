<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Campaign;

class DashboardController extends Controller
{
    /**
     * Handle the operational core dashboard dashboard view.
     */
    public function index(Request $request)
    {
        $connectedPlatforms = $request->user()->socialAccounts()->pluck('provider')->toArray();
        
        if ($request->query('new')) {
            return view('dashboard', [
                'state' => 'A',
                'project' => null,
                'campaign' => null,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        $projectId = $request->query('project_id');
        if ($projectId) {
            $project = $request->user()->projects()->where('id', $projectId)->first();
        } else {
            $project = $request->user()->projects()->latest()->first();
        }

        if (!$project) {
            return view('dashboard', [
                'state' => 'A',
                'project' => null,
                'campaign' => null,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        $campaign = $project->campaigns()->latest()->first();

        if (!$campaign) {
            // No campaign exists yet, treat as State A (empty state to let user start campaign)
            return view('dashboard', [
                'state' => 'A',
                'project' => $project,
                'campaign' => null,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        if ($campaign->status === 'generating') {
            return view('dashboard', [
                'state' => 'B',
                'project' => $project,
                'campaign' => $campaign,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        if ($campaign->status === 'failed_generation') {
            return view('dashboard', [
                'state' => 'FAILED',
                'project' => $project,
                'campaign' => $campaign,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        // If the campaign is already active (approved), free up the dashboard for a new generation (State A)
        if ($campaign->status === 'active') {
            return view('dashboard', [
                'state' => 'A',
                'project' => null,
                'campaign' => null,
                'posts' => collect(),
                'connectedPlatforms' => $connectedPlatforms,
            ]);
        }

        // Campaign is ready (draft, ready, active, completed, etc.)
        // Load the posts grouped/ordered for the 30-day grid
        $posts = $campaign->posts()->orderBy('day_number')->orderBy('platform')->get();

        return view('dashboard', [
            'state' => 'C',
            'project' => $project,
            'campaign' => $campaign,
            'posts' => $posts,
            'connectedPlatforms' => $connectedPlatforms,
        ]);
    }
}
