<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    // SECURITY FIX B-1: Explicit fillable
    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'username',
        'access_token',
        'refresh_token',
        'expires_at',
        'quarantined_until',
        'refresh_failures',
        'scopes',
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
