<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDataDeletion;
use App\Models\DataDeletionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FacebookDataDeletionController extends Controller
{
    public function handle(Request $request)
    {
        $signedRequest = $request->input('signed_request');
        if (! $signedRequest) {
            return response()->json(['error' => 'Missing signed_request'], 400);
        }

        [$encodedSig, $payload] = explode('.', $signedRequest, 2);

        $secret = config('services.facebook.client_secret');

        // Decode signature
        $sig = $this->base64UrlDecode($encodedSig);

        // Decode payload
        $data = json_decode($this->base64UrlDecode($payload), true);

        if (! $data || ! isset($data['user_id'])) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Verify signature
        $expectedSig = hash_hmac('sha256', $payload, $secret, true);
        if (! hash_equals($expectedSig, $sig)) {
            Log::error('Invalid Facebook Data Deletion Signature');

            return response()->json(['error' => 'Bad signature'], 400);
        }

        // Generate confirmation code
        $confirmationCode = Str::random(20);

        // Save request to database
        DataDeletionRequest::create([
            'provider' => 'facebook',
            'provider_user_id' => $data['user_id'],
            'confirmation_code' => $confirmationCode,
            'status' => 'pending',
        ]);

        // Dispatch Job
        ProcessDataDeletion::dispatch('facebook', $data['user_id'], $confirmationCode);

        // Return expected JSON response
        return response()->json([
            'url' => route('socials.facebook.data-deletion-status', ['code' => $confirmationCode]),
            'confirmation_code' => $confirmationCode,
        ]);
    }

    public function status($code)
    {
        $deletionRequest = DataDeletionRequest::where('confirmation_code', $code)->firstOrFail();

        return view('socials.data-deletion-status', [
            'request' => $deletionRequest,
        ]);
    }

    private function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
