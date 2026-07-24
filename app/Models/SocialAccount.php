<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    // SECURITY FIX B-1: Explicit fillable
    protected $fillable = [
        'user_id',
        'project_id',
        'provider',
        'provider_user_id',
        'username',
        'access_token',
        'refresh_token',
        'expires_at',
        'scopes',
        'refresh_failures',
        'quarantined_until',
        'is_premium',
    ];

    // SECURITY FIX AUDIT-3: Prevent token ciphertext from leaking in JSON serialization
    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected $casts = [
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'expires_at' => 'datetime',
        'quarantined_until' => 'datetime',
        'is_premium' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
