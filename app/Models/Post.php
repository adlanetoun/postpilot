<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // SECURITY FIX B-1: Explicit fillable instead of unguarded mass assignment
    protected $fillable = [
        'campaign_id',
        'social_account_id',
        'platform',
        'content',
        'status',
        'day_number',
        'scheduled_at',
        'published_at',
        'platform_post_id',
        'error_message',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime:Y-m-d H:i:s',
        'published_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }
}
