<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = ['from_path', 'to_path', 'status_code', 'is_active', 'hits'];

    protected $casts = [
        'is_active' => 'boolean',
        'status_code' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Redirect $redirect) {
            // Request::path() (utilisé par le middleware de redirection) ne
            // renvoie jamais de slash final : on normalise donc de la même
            // façon ici pour que la comparaison fonctionne à coup sûr.
            $redirect->from_path = '/'.trim($redirect->from_path, '/');
            $redirect->to_path = str_starts_with($redirect->to_path, 'http')
                ? $redirect->to_path
                : '/'.trim($redirect->to_path, '/');
        });
    }
}
