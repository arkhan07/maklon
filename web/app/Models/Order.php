<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'product_name', 'product_type',
        'quantity', 'notes', 'status', 'admin_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu Konfirmasi',
            'processing' => 'Diproses',
            'qc'         => 'Quality Control',
            'shipping'   => 'Pengiriman',
            'done'       => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'    => 'bg-yellow-50 text-yellow-700',
            'processing' => 'bg-amber-50 text-amber-700',
            'qc'         => 'bg-blue-50 text-blue-700',
            'shipping'   => 'bg-purple-50 text-purple-700',
            'done'       => 'bg-emerald-50 text-emerald-700',
            'cancelled'  => 'bg-slate-100 text-slate-700',
            default      => 'bg-slate-100 text-slate-700',
        };
    }

    public static function generateOrderNumber(): string
    {
        $last = static::latest()->first();
        $next = $last ? (int) substr($last->order_number, 3) + 1 : 1;
        return 'MK-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}
