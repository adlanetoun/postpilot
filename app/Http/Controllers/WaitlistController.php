<?php

namespace App\Http\Controllers;

use App\Models\WaitlistSignup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WaitlistController extends Controller
{
    /**
     * Capture an annual-plan waitlist signup from any authenticated surface
     * (profile edit page, exit-intent popup, etc.).
     *
     * Idempotent: re-submission updates the timestamp rather than creating dupes.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'plan_interest' => ['nullable', 'string', Rule::in(['annual', 'team', 'agency'])],
            'source' => ['nullable', 'string', 'max:64'],
        ]);

        $email = $validated['email'];
        $plan = $validated['plan_interest'] ?? 'annual';
        $source = $validated['source'] ?? 'profile_edit';

        $signup = WaitlistSignup::updateOrCreate(
            ['email' => $email, 'plan_interest' => $plan],
            [
                'user_id' => Auth::id(),
                'source' => $source,
                'metadata' => array_filter([
                    'referer' => substr($request->headers->get('referer') ?? '', 0, 500),
                    'user_agent_browser' => $request->headers->get('sec-ch-ua'),
                ]),
            ]
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'message' => "You're on the list! We'll email you when annual plans launch.",
                'position' => WaitlistSignup::where('plan_interest', $plan)->count(),
            ]);
        }

        return redirect()->back()->with(
            'success',
            "🎉 You're on the annual-plan waitlist! We'll email you when early-bird pricing goes live."
        );
    }
}
