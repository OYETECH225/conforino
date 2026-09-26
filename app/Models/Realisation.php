<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Realisation extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'service_id', 'city_id', 'description', 'surface', 'duration',
        'is_featured', 'is_published', 'order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('before')->singleFile();
        $this->addMediaCollection('after')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('webp')->format('webp')->quality(82)->nonQueued();
        $this->addMediaConversion('thumb')->format('webp')->width(640)->quality(80)->nonQueued();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('created_at');
    }

    public function beforeUrl(string $conversion = 'webp'): ?string
    {
        return $this->getFirstMediaUrl('before', $conversion) ?: $this->getFirstMediaUrl('before');
    }

    public function afterUrl(string $conversion = 'webp'): ?string
    {
        return $this->getFirstMediaUrl('after', $conversion) ?: $this->getFirstMediaUrl('after');
    }
}
