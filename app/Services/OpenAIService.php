<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class OpenAIService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.cerebras.base_url', 'https://api.cerebras.ai/v1');
        $this->apiKey = config('services.cerebras.key');
    }

    public function generateJson(string $model, string $prompt, int $maxTokens = 3000): array
    {
        // SECURITY FIX 12-A: Removed ->withoutVerifying() to enforce TLS certificate validation.
        // This prevents MITM attacks that could intercept the API key and prompt data.
        $http = Http::connectTimeout(5)->timeout(60);
        
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a strict JSON generator. Output ONLY a valid JSON object. It MUST contain a single key "posts" which is an array of objects. Do not include markdown formatting like ```json. Do not include trailing commas. Do not output anything except JSON.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'], // Forces JSON mode if supported
            'max_tokens' => $maxTokens,
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            // SECURITY FIX 2-B: Sanitize error output to prevent API key / internal metadata leakage
            $safeBody = Str::limit($response->body(), 200);
            Log::error('Cerebras API Error', ['status' => $response->status(), 'body' => $safeBody]);
            throw new Exception('AI generation service returned an error (HTTP ' . $response->status() . '). Please try again.');
        }

        $rawContent = $response->json('choices.0.message.content');

        if (!$rawContent) {
            Log::error('Invalid Cerebras response format', ['status' => $response->status()]);
            throw new Exception('AI generation service returned an unexpected response format. Please try again.');
        }

        // Safety Net 1: Clean markdown wrappers just in case the model ignores system prompts
        $cleanedContent = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($rawContent));

        // Safety Net 2: Extract the outermost JSON object using a greedy regex
        // This saves us if the LLM says "Here is your plan: { ... }"
        if (preg_match('/\{[\s\S]*\}/', $cleanedContent, $matches)) {
            $cleanedContent = $matches[0];
        }

        $decoded = json_decode($cleanedContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Decode Error', [
                'error' => json_last_error_msg(),
                'content' => Str::limit($cleanedContent, 500)
            ]);
            throw new Exception('Invalid JSON returned from AI service: ' . json_last_error_msg());
        }

        return isset($decoded['posts']) ? $decoded['posts'] : $decoded;
    }
}
