<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'short_description', 'long_description', 'icon',
        'is_active', 'order', 'meta_title', 'meta_description', 'canonical_url', 'robots',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(82)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(640)
            ->quality(80)
            ->nonQueued();
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'service_city')
            ->using(ServiceCity::class)
            ->withPivot(['local_intro', 'meta_title_override', 'meta_description_override', 'is_published'])
            ->withTimestamps();
    }

    public function realisations(): HasMany
    {
        return $this->hasMany(Realisation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    /**
     * Titre meta pour la page service seule (sans ville), avec repli intelligent.
     */
    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->title.' | CONFOR\'INO Argenteuil';
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description ?: $this->short_description;
    }

    /**
     * Titre meta pour la déclinaison service + ville, avec repli intelligent
     * si aucune surcharge n'est définie sur le pivot.
     */
    public function metaTitleFor(City $city, ?ServiceCity $pivot = null): string
    {
        $override = $pivot?->meta_title_override;

        return $override ?: "{$this->title} à {$city->name} (95) | CONFOR'INO";
    }

    public function metaDescriptionFor(City $city, ?ServiceCity $pivot = null): ?string
    {
        $override = $pivot?->meta_description_override;

        return $override ?: "CONFOR'INO réalise vos travaux de {$this->title} à {$city->name}. Devis gratuit, garantie décennale, RC professionnelle.";
    }

    public function imageUrl(string $conversion = 'webp'): ?string
    {
        return $this->getFirstMediaUrl('image', $conversion) ?: $this->getFirstMediaUrl('image') ?: null;
    }
}
