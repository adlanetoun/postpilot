<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // SECURITY FIX B-1: Explicit fillable instead of unguarded mass assignment
    protected $fillable = [
        'user_id',
        'name',
        'website_url',
        'description',
        'target_audience',
        'value_proposition',
        'tone_of_voice',
        'language',
        'platforms',
    ];

    protected $casts = [
        'platforms' => 'array',
    ];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
