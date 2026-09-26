<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'city', 'message', 'source_url', 'consented_at', 'handled_at',
    ];

    protected $casts = [
        'consented_at' => 'datetime',
        'handled_at' => 'datetime',
    ];
}
