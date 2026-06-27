<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessDodoWebhookJob;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DodoWebhookController extends Controller
{
    public function handle(Request $request) 
    {
        // 1. Verify Signature — SECURITY FIX 4-A: ALWAYS validate, regardless of environment
        $signature = $request->header('X-Dodo-Signature');
        $payload = $request->getContent();
        
        $secret = config('services.dodo.webhook_secret');
        
        // The secret MUST be present in ALL environments
        if (!$secret) {
            Log::critical('Dodo Webhook Secret is missing! Webhook rejected.', ['ip' => $request->ip()]);
            abort(500, 'Webhook configuration error');
        }

        // Always validate the signature — no environment-based bypass
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        if (!$signature || !hash_equals($expectedSignature, $signature)) {
            Log::warning('Dodo Webhook Signature Mismatch', ['ip' => $request->ip()]);
            abort(403, 'Invalid signature');
        }

        // 2. ZERO-DATA-LOSS: Persist raw payload synchronously
        $webhookLog = WebhookLog::create([
            'provider' => 'dodo',
            'event_type' => $request->input('type', 'unknown'),
            'event_id' => $request->input('data.subscription_id', $request->input('data.payment_id', $request->input('id', uniqid()))),
            'payload' => $request->all(),
        ]);

        // 3. Dispatch Job
        ProcessDodoWebhookJob::dispatch($webhookLog);
        
        // 4. Return 200 IMMEDIATELY
        return response()->json(['status' => 'received'], 200);
    }
}
