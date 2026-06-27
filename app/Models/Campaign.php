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
        'raw_llm_payload_path',
        'error_message',
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
