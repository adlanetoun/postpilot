<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    // SECURITY FIX B-1: Explicit fillable instead of unguarded mass assignment
    protected $fillable = [
        'project_id',
        'status',
        'description',
        'target_audience',
        'value_proposition',
        'tone_of_voice',
        'language',
        'platforms',
        'is_demo',
        'raw_llm_payload_path',
        'error_message',
    ];

    protected $casts = [
        'platforms' => 'array',
        'is_demo' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
