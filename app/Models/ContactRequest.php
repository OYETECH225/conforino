<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContactRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'phone', 'email', 'city', 'address', 'property_type', 'surface',
        'service_id', 'beneficiary_type', 'preferred_day', 'preferred_time_slot',
        'message', 'source_url', 'consented_at', 'handled_at',
    ];

    public const PROPERTY_TYPES = [
        'appartement' => 'Appartement',
        'maison' => 'Maison',
        'local_professionnel' => 'Local professionnel',
    ];

    public const BENEFICIARY_TYPES = [
        'self' => 'Pour moi-même',
        'other' => 'Pour un proche (aidant familial)',
    ];

    public const TIME_SLOTS = [
        'matin' => 'Matin (08h30 - 12h00)',
        'apres_midi' => 'Après-midi (13h30 - 17h30)',
        'soir' => 'Fin de journée (17h30 - 19h00)',
    ];

    protected $casts = [
        'consented_at' => 'datetime',
        'handled_at' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }
}
