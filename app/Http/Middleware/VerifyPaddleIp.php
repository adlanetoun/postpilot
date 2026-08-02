<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Verify that webhook requests originate from Paddle's published IP ranges.
 *
 * Fetches the authoritative list from https://api.paddle.com/ips (live)
 * or https://sandbox-api.paddle.com/ips (sandbox) and caches it for 24 hours.
 * Requests from unrecognised IPs are rejected with 403.
 */
class VerifyPaddleIp
{
    /** Cache key for the resolved IP list. */
    private const CACHE_KEY = 'paddle_allowed_ips';

    /** Cache TTL in seconds (24 hours). */
    private const CACHE_TTL = 86400;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip IP verification in local/testing environments
        if (app()->environment('local', 'testing')) {
            return $next($request);
        }

        $allowedIps = $this->getAllowedIps();

        if (empty($allowedIps)) {
            // If we can't fetch IPs, log a warning but allow through
            // (signature verification is the primary security gate)
            Log::warning('Paddle IP allowlist is empty — skipping IP check. Signature verification still active.');

            return $next($request);
        }

        $requestIp = $request->ip();

        if (! in_array($requestIp, $allowedIps, true)) {
            Log::warning('Paddle webhook rejected: IP not in allowlist.', [
                'ip' => $requestIp,
                'allowed' => $allowedIps,
            ]);

            throw new AccessDeniedHttpException('Unauthorized webhook source IP.');
        }

        return $next($request);
    }

    /**
     * Fetch and cache Paddle's allowed webhook IPs.
     *
     * @return array<string>
     */
    private function getAllowedIps(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function (): array {
            $isSandbox = config('cashier.sandbox', false);
            $baseUrl = $isSandbox
                ? 'https://sandbox-api.paddle.com/ips'
                : 'https://api.paddle.com/ips';

            try {
                $response = Http::timeout(10)->get($baseUrl);

                if (! $response->successful()) {
                    Log::error("Failed to fetch Paddle IPs from {$baseUrl}", [
                        'status' => $response->status(),
                    ]);

                    return [];
                }

                $cidrs = $response->json('data.ipv4_cidrs', []);

                // Convert /32 CIDRs to plain IPs
                return array_map(function (string $cidr): string {
                    return explode('/', $cidr)[0];
                }, $cidrs);
            } catch (\Throwable $e) {
                Log::error('Exception fetching Paddle IPs: '.$e->getMessage());

                return [];
            }
        });
    }
}
