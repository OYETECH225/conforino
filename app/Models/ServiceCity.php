<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceCity extends Pivot
{
    protected $table = 'service_city';

    protected $fillable = [
        'service_id', 'city_id', 'local_intro',
        'meta_title_override', 'meta_description_override', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
