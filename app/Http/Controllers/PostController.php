<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Update the specified post content (IDOR safe).
     */
    public function update(Request $request, Post $post)
    {
        // Enforce IDOR protection using PostPolicy
        Gate::authorize('update', $post);

        // SECURITY FIX VULN-22: Block editing posts that have already been published or are mid-publish.
        if (in_array($post->status, ['published', 'publishing'])) {
            return back()
                ->with('error', 'Cannot edit a post that has already been published or is currently publishing.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $post->update([
            'content' => $validated['content'],
        ]);

        return back()
            ->with('success', 'Post updated successfully.')
            ->with('open_day', $post->day_number);
    }
}
