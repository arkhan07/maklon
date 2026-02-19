<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'order_id', 'user_id', 'type', 'status',
        'subtotal_legal', 'subtotal_product', 'subtotal_sample',
        'ppn_amount', 'amount', 'due_date', 'paid_at', 'notes',
    ];

    protected $casts = [
        'subtotal_legal' => 'decimal:2',
        'subtotal_product' => 'decimal:2',
        'subtotal_sample' => 'decimal:2',
        'ppn_amount' => 'decimal:2',
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
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

    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
