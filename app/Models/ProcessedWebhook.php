<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class ProcessedWebhook extends Model
{
    use Prunable;

    public function prunable()
    {
        return static::where('created_at', '<', now()->subDays(90));
    }

    // SECURITY FIX B-1: Explicit fillable
    protected $fillable = [
        'event_id',
        'event_type',
        'payload',
    ];

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
