<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // SECURITY FIX B-1: Explicit fillable instead of unguarded mass assignment
    protected $fillable = [
        'user_id',
        'dodo_subscription_id',
        'dodo_customer_id',
        'status',
        'plan_name',
        'trial_ends_at',
        'ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
