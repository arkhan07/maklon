<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionTracking extends Model
{
    protected $fillable = [
        'order_id', 'status', 'notes', 'updated_by',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'antri' => 'Antri Produksi',
            'mixing' => 'Proses Mixing',
            'qc' => 'Quality Control',
            'packing' => 'Packing & Labeling',
            'ready_to_ship' => 'Siap Kirim',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }
}
