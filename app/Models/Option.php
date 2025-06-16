<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = ['parent_id', 'group', 'label', 'value'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Option::class, 'parent_id');
    }
}