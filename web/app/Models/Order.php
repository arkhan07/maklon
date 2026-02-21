<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status',
        'product_name', 'product_type',
        'brand_type', 'brand_name', 'include_bpom', 'include_halal', 'include_logo', 'include_haki',
        'product_id', 'volume_ml', 'selected_materials',
        'packaging_type_id', 'quantity',
        'design_option', 'design_file_url', 'design_description', 'request_sample',
        'legal_cost', 'base_cost', 'material_cost', 'packaging_cost', 'design_cost',
        'sample_cost', 'ppn', 'total_amount', 'dp_amount', 'remaining_amount',
        'production_status', 'tracking_number', 'courier',
        'current_step', 'mou_status', 'notes',
        'confirmed_at', 'completed_at',
    ];

    protected $casts = [
        'selected_materials' => 'array',
        'include_bpom'       => 'boolean',
        'include_halal'      => 'boolean',
        'include_logo'       => 'boolean',
        'include_haki'       => 'boolean',
        'request_sample'     => 'boolean',
        'legal_cost'         => 'decimal:2',
        'base_cost'          => 'decimal:2',
        'material_cost'      => 'decimal:2',
        'packaging_cost'     => 'decimal:2',
        'design_cost'        => 'decimal:2',
        'sample_cost'        => 'decimal:2',
        'ppn'                => 'decimal:2',
        'total_amount'       => 'decimal:2',
        'dp_amount'          => 'decimal:2',
        'remaining_amount'   => 'decimal:2',
        'confirmed_at'       => 'datetime',
        'completed_at'       => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function packagingType(): BelongsTo
    {
        return $this->belongsTo(PackagingType::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function mouDocument(): HasOne
    {
        return $this->hasOne(MouDocument::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'draft'       => 'Draft',
            'pending'     => 'Menunggu Konfirmasi',
            'confirmed'   => 'Dikonfirmasi',
            'in_progress' => 'Dalam Produksi',
            'completed'   => 'Selesai',
            'cancelled'   => 'Dibatalkan',
            default       => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'draft'       => 'bg-slate-100 text-slate-600',
            'pending'     => 'bg-amber-100 text-amber-700',
            'confirmed'   => 'bg-blue-100 text-blue-700',
            'in_progress' => 'bg-violet-100 text-violet-700',
            'completed'   => 'bg-emerald-100 text-emerald-700',
            'cancelled'   => 'bg-red-100 text-red-600',
            default       => 'bg-slate-100 text-slate-600',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->statusLabel();
    }

    public function getProductionStatusLabelAttribute(): string
    {
        return match($this->production_status) {
            'antri'       => 'Antri Produksi',
            'mixing'      => 'Mixing Formula',
            'qc'          => 'Quality Control',
            'packing'     => 'Packing & Labeling',
            'siap_kirim'  => 'Siap Dikirim',
            'terkirim'    => 'Terkirim',
            default       => '-',
        };
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'MKL';
        $date   = now()->format('Ymd');
        $last   = static::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals(): void
    {
        $subtotalProduk = $this->base_cost + $this->material_cost + $this->packaging_cost
                        + $this->design_cost;
        $this->ppn            = ($subtotalProduk + $this->legal_cost) * 0.11;
        $this->total_amount   = $subtotalProduk + $this->legal_cost + $this->ppn + $this->sample_cost;
        $this->dp_amount      = $this->legal_cost + $this->sample_cost + ($subtotalProduk * 0.5);
        $this->remaining_amount = $subtotalProduk * 0.5;
    }
}
