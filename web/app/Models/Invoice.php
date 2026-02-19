<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'invoice_number', 'amount',
        'status', 'due_date', 'paid_at', 'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'amount'   => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Belum Dibayar',
            'paid'     => 'Lunas',
            'overdue'  => 'Jatuh Tempo',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'  => 'bg-yellow-50 text-yellow-700',
            'paid'     => 'bg-emerald-50 text-emerald-700',
            'overdue'  => 'bg-red-50 text-red-700',
            default    => 'bg-slate-100 text-slate-700',
        };
    }

    public function formattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public static function generateInvoiceNumber(): string
    {
        $last = static::latest()->first();
        $next = $last ? (int) substr($last->invoice_number, 4) + 1 : 1;
        return 'INV-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}
