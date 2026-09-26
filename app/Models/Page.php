<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'breadcrumb_title', 'status',
        'meta_title', 'meta_description', 'canonical_url', 'robots', 'schema_type',
        'show_breadcrumb', 'published_at',
    ];

    protected $casts = [
        'show_breadcrumb' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('og_image')->singleFile();
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class)->orderBy('order');
    }

    public function activeBlocks(): HasMany
    {
        return $this->blocks()->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->title.' | CONFOR\'INO';
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function canonicalUrl(): string
    {
        return $this->canonical_url ?: url($this->slug === 'accueil' ? '/' : '/'.$this->slug);
    }

    public function ogImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('og_image') ?: null;
    }
}
