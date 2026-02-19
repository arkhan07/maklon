<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackagingType extends Model
{
    protected $fillable = [
        'name', 'description', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PackagingOption::class)->orderBy('sort_order');
    }
}
