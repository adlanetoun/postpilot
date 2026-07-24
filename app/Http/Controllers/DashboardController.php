<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Campaign;

class DashboardController extends Controller
{
    /**
     * Handle the operational core dashboard view.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $projects = $user->projects()->with(['campaigns' => function($q) {
            $q->latest();
        }, 'socialAccounts'])->latest()->get();
        
        if ($projects->isEmpty()) {
            return view('dashboard', [
                'state' => 'A',
                'projects' => $projects,
            ]);
        }

        return view('dashboard', [
            'state' => 'LIST',
            'projects' => $projects,
        ]);
    }
}
