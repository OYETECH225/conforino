<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    public const TYPE_HERO = 'hero';
    public const TYPE_RICH_TEXT = 'rich_text';
    public const TYPE_SERVICES_GRID = 'services_grid';
    public const TYPE_TESTIMONIALS = 'testimonials';
    public const TYPE_FAQ = 'faq';
    public const TYPE_SERVICE_AREAS = 'service_areas';
    public const TYPE_CONTACT_FORM = 'contact_form';
    public const TYPE_STATS = 'stats';
    public const TYPE_BEFORE_AFTER = 'before_after';
    public const TYPE_PROCESS = 'process';
    public const TYPE_GALLERY_PREVIEW = 'gallery_preview';

    public const TYPES = [
        self::TYPE_HERO => 'Hero',
        self::TYPE_RICH_TEXT => 'Texte riche',
        self::TYPE_SERVICES_GRID => 'Grille de services',
        self::TYPE_TESTIMONIALS => 'Témoignages',
        self::TYPE_FAQ => 'FAQ',
        self::TYPE_SERVICE_AREAS => 'Zones desservies',
        self::TYPE_CONTACT_FORM => 'Formulaire de contact',
        self::TYPE_STATS => 'Chiffres clés',
        self::TYPE_BEFORE_AFTER => 'Avant / Après',
        self::TYPE_PROCESS => 'Parcours client (étapes numérotées)',
        self::TYPE_GALLERY_PREVIEW => 'Aperçu réalisations',
    ];

    protected $fillable = ['page_id', 'type', 'data', 'order', 'is_active'];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function get(string $key, $default = null)
    {
        return data_get($this->data, $key, $default);
    }
}
