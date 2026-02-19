<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $fillable = [
        'name', 'category', 'price_per_ml', 'description', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'price_per_ml' => 'decimal:4',
        'is_available' => 'boolean',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_materials')
            ->withPivot('dose_ml', 'price_per_ml', 'subtotal')
            ->withTimestamps();
    }
}
