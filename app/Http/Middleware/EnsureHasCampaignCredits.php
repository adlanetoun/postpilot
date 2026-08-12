<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasCampaignCredits
{
    /**
     * Handle an incoming request.
     *
     * CRO FIX: Instead of bouncing users to /settings (full-page reload that
     * loses context), flash an 'insufficient_credits' session key so the
     * layout renders an in-app modal at the top of the same page they were on.
     * Falls back to redirect only for non-GET requests (form submissions) or
     * when the request explicitly expects a redirect (e.g. AJAX).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        $user = $request->user();

        // ONE-TIME FREE DEMO: Users with no credits can generate EXACTLY ONE
        // demo campaign in their account lifetime. After that, they must
        // purchase credits to generate anything else (real or demo).
        if (! $user->hasCampaignCredits() && ! $user->canUseFreeDemo()) {
            // Truly blocked — must purchase credits
            if ($request->method() !== 'GET' || $request->expectsJson() || $request->ajax()) {
                return redirect('/settings?tab=billing&error=credits_required');
            }

            return redirect()->back()->with('insufficient_credits', true);
        }

        return $next($request);
    }
}
