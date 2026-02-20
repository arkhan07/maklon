<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name', 'category', 'price_per_ml', 'description',
        'is_available', 'sort_order',
    ];

    protected $casts = [
        'price_per_ml' => 'decimal:4',
        'is_available' => 'boolean',
    ];

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_ml, 0, ',', '.');
    }
}
