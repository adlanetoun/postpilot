<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyPaddleIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tests\TestCase as BaseTestCase;

class VerifyPaddleIpTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function testSkipsIpCheckInLocalEnvironment(): void
    {
        // Default test environment is 'testing', which should be skipped
        $middleware = new VerifyPaddleIp;

        $request = Request::create('/webhooks/paddle', 'POST');
        $request->server->set('REMOTE_ADDR', '999.999.999.999');

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAllowsRequestFromPaddleIpInProduction(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        // Pre-seed cache with known IPs
        Cache::put('paddle_allowed_ips', ['34.237.3.244', '34.195.105.136'], 86400);

        $middleware = new VerifyPaddleIp;

        $request = Request::create('/webhooks/paddle', 'POST');
        $request->server->set('REMOTE_ADDR', '34.237.3.244');

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRejectsRequestFromUnknownIpInProduction(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        // Pre-seed cache with known IPs
        Cache::put('paddle_allowed_ips', ['34.237.3.244', '34.195.105.136'], 86400);

        $middleware = new VerifyPaddleIp;

        $request = Request::create('/webhooks/paddle', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');

        $this->expectException(AccessDeniedHttpException::class);

        $middleware->handle($request, function ($req) {
            return response('OK');
        });
    }

    public function testAllowsThroughWhenIpListIsEmpty(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        // Empty IP list — should allow through (graceful fallback)
        Cache::put('paddle_allowed_ips', [], 86400);

        $middleware = new VerifyPaddleIp;

        $request = Request::create('/webhooks/paddle', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
    }
}
