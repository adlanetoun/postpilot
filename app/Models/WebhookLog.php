<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class WebhookLog extends Model
{
    use Prunable;

    public function prunable()
    {
        return static::where('created_at', '<', now()->subDays(90));
    }

    // SECURITY FIX B-1: Explicit fillable
    protected $fillable = [
        'provider',
        'event_type',
        'event_id',
        'payload',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
