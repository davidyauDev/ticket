<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'status',
        'last_connected_at',
        'is_current',
    ];

    protected $casts = [
        'session_id' => 'string',
        'status' => 'string',
        'last_connected_at' => 'datetime',
        'is_current' => 'boolean',
    ];
}