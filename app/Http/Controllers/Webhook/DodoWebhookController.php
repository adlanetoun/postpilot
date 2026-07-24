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
        $payload = $request->getContent();
        
        // Dodo Payments uses Standard Webhooks (Svix) headers
        $msgId = $request->header('webhook-id') ?? $request->header('svix-id');
        $msgTimestamp = $request->header('webhook-timestamp') ?? $request->header('svix-timestamp');
        $signatureHeader = $request->header('webhook-signature') ?? $request->header('svix-signature') ?? $request->header('X-Dodo-Signature');
        
        $secret = config('services.dodo.webhook_secret');
        
        // Log headers for debugging incoming webhooks
        Log::info('Dodo Webhook received.', [
            'webhook_id' => $msgId,
            'webhook_timestamp' => $msgTimestamp,
            'has_signature' => !empty($signatureHeader),
            'environment' => app()->environment(),
        ]);

        if (!empty($secret) && !empty($signatureHeader) && !empty($msgId) && !empty($msgTimestamp)) {
            $isValid = $this->verifySvixSignature($msgId, $msgTimestamp, $payload, $secret, $signatureHeader);
            
            if (!$isValid) {
                Log::warning('Dodo Webhook Signature Verification Failed', [
                    'ip' => $request->ip(),
                    'msg_id' => $msgId,
                    'signature_header' => $signatureHeader,
                ]);

                if (!app()->environment('local')) {
                    abort(403, 'Invalid signature');
                }
            } else {
                Log::info('Dodo Webhook Signature Verified Successfully.');
            }
        } else {
            if (!app()->environment('local')) {
                Log::critical('Missing Webhook Secret or required Svix headers in production.', [
                    'secret_present' => !empty($secret),
                    'signature_present' => !empty($signatureHeader),
                ]);
                abort(403, 'Missing signature headers');
            } else {
                Log::info('Bypassing strict signature enforcement in local environment (missing secret or headers).');
            }
        }

        // 2. ZERO-DATA-LOSS: Persist raw payload synchronously
        $eventId = $request->input('data.subscription_id')
            ?? $request->input('data.payment_id')
            ?? $request->input('id')
            ?? $msgId
            ?? uniqid();

        $webhookLog = WebhookLog::create([
            'provider' => 'dodo',
            'event_type' => $request->input('type', 'unknown'),
            'event_id' => $eventId,
            'payload' => $request->all(),
        ]);

        // 3. Dispatch Job
        ProcessDodoWebhookJob::dispatch($webhookLog);
        
        // 4. Return 200 OK IMMEDIATELY
        return response()->json(['status' => 'received'], 200);
    }

    /**
     * Verify Standard Webhooks (Svix) HMAC-SHA256 Signature
     */
    private function verifySvixSignature(string $msgId, string $msgTimestamp, string $payload, string $secret, string $signatureHeader): bool
    {
        // 1. Unpack secret: Svix secrets usually start with 'whsec_' and are base64 encoded
        $secretKey = $secret;
        if (str_starts_with($secret, 'whsec_')) {
            $secretKey = base64_decode(substr($secret, 6));
        }

        // 2. Construct signed payload string
        $toSign = "{$msgId}.{$msgTimestamp}.{$payload}";
        $expectedSignature = base64_encode(hash_hmac('sha256', $toSign, $secretKey, true));

        // 3. Header contains space-separated signature items, e.g. "v1,signature1 v1,signature2"
        $signatures = explode(' ', $signatureHeader);
        foreach ($signatures as $sigItem) {
            $parts = explode(',', trim($sigItem), 2);
            if (count($parts) === 2 && $parts[0] === 'v1') {
                if (hash_equals($expectedSignature, $parts[1])) {
                    return true;
                }
            }
        }

        return false;
    }
}
