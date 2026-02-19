<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackagingOption extends Model
{
    protected $fillable = [
        'packaging_type_id', 'name', 'description', 'volume_ml',
        'price', 'image_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function packagingType(): BelongsTo
    {
        return $this->belongsTo(PackagingType::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
