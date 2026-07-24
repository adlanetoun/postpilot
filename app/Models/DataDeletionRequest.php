<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'provider_user_id',
        'confirmation_code',
        'status',
        'notes',
    ];
}
