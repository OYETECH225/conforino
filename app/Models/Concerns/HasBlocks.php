<?php

namespace App\Models\Concerns;

use App\Models\Block;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasBlocks
{
    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'blockable')->orderBy('order');
    }

    public function activeBlocks(): MorphMany
    {
        return $this->blocks()->where('is_active', true);
    }
}
