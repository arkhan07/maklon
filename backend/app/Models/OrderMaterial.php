<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderMaterial extends Model
{
    protected $fillable = [
        'order_id', 'material_id', 'dose_ml', 'price_per_ml', 'subtotal',
    ];

    protected $casts = [
        'dose_ml' => 'decimal:4',
        'price_per_ml' => 'decimal:4',
        'subtotal' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
