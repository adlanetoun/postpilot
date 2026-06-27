<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::whereHas('campaign.project', function($q) {
            $q->where('user_id', Auth::id());
        })
        ->whereIn('status', ['approved', 'published', 'failed'])
        ->whereNotNull('scheduled_at')
        ->orderBy('scheduled_at', 'asc')
        ->get();

        return view('calendar.index', compact('posts'));
    }
}
