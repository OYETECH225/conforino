<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SanitaryService extends Model
{
    use HasSlug;

    protected $fillable = [
        'title', 'slug', 'icon', 'image', 'short_description',
        'price', 'price_is_from', 'price_note', 'duration_label',
        'included_items', 'excluded_items', 'client_provides', 'extra_note',
        'is_active', 'order', 'meta_title', 'meta_description', 'robots',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_is_from' => 'boolean',
        'included_items' => 'array',
        'excluded_items' => 'array',
        'client_provides' => 'array',
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    public function priceLabel(): string
    {
        $amount = number_format((float) $this->price, (float) $this->price == (int) $this->price ? 0 : 2, ',', ' ');

        return ($this->price_is_from ? 'À partir de ' : '').$amount.'€';
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($this->image, ['http', '/storage'])
            ? $this->image
            : asset('storage/'.$this->image);
    }

    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->title." | CONFOR'INO Argenteuil";
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description ?: $this->short_description;
    }
}
