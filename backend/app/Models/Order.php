<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status',
        'brand_type', 'brand_name', 'brand_logo_url', 'brand_description',
        'brand_visual_description', 'brand_name_translation',
        'include_bpom', 'include_halal', 'include_haki_logo', 'include_haki_djki',
        'product_id', 'volume_ml', 'quantity',
        'packaging_option_id',
        'design_type', 'design_file_url', 'design_description', 'design_price',
        'sample_requested', 'sample_price', 'sample_revisions_used', 'sample_status',
        'subtotal_legal', 'subtotal_product', 'ppn_rate', 'ppn_amount', 'grand_total',
        'dp_amount', 'remaining_amount',
        'shipping_tracking', 'shipping_courier', 'shipped_at', 'completed_at',
        'admin_notes',
    ];

    protected $casts = [
        'include_bpom' => 'boolean',
        'include_halal' => 'boolean',
        'include_haki_logo' => 'boolean',
        'include_haki_djki' => 'boolean',
        'sample_requested' => 'boolean',
        'subtotal_legal' => 'decimal:2',
        'subtotal_product' => 'decimal:2',
        'ppn_rate' => 'decimal:2',
        'ppn_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'design_price' => 'decimal:2',
        'sample_price' => 'decimal:2',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function packagingOption(): BelongsTo
    {
        return $this->belongsTo(PackagingOption::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'order_materials')
            ->withPivot('dose_ml', 'price_per_ml', 'subtotal')
            ->withTimestamps();
    }

    public function orderMaterials(): HasMany
    {
        return $this->hasMany(OrderMaterial::class);
    }

    public function legalItems(): HasMany
    {
        return $this->hasMany(OrderLegalItem::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function mou(): HasOne
    {
        return $this->hasOne(Mou::class);
    }

    public function productionTrackings(): HasMany
    {
        return $this->hasMany(ProductionTracking::class)->orderBy('created_at');
    }

    public function latestTracking(): HasOne
    {
        return $this->hasOne(ProductionTracking::class)->latestOfMany();
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'MKL';
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
