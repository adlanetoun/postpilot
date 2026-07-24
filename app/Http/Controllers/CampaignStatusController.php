<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignStatusController extends Controller
{
    /**
     * Get the JSON status of a campaign.
     */
    public function show(Campaign $campaign)
    {
        // Verify ownership
        if ($campaign->project->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $status = $campaign->status;

        // Map draft, ready, active, completed to 'ready' for polling success trigger
        if (in_array($status, ['draft', 'ready', 'active', 'completed'])) {
            $status = 'ready';
        }

        return response()->json([
            'status' => $status,
            'failure_reason' => $campaign->error_message,
        ]);
    }
}
