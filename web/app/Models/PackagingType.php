<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagingType extends Model
{
    protected $fillable = [
        'name', 'type', 'price', 'image', 'description', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
