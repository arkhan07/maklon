<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'user_id', 'amount', 'method',
        'proof_file', 'status', 'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'  => 'bg-yellow-50 text-yellow-700',
            'verified' => 'bg-emerald-50 text-emerald-700',
            'rejected' => 'bg-red-50 text-red-700',
            default    => 'bg-slate-100 text-slate-700',
        };
    }

    public function methodLabel(): string
    {
        return match($this->method) {
            'transfer'       => 'Transfer Bank',
            'qris'           => 'QRIS',
            'virtual_account' => 'Virtual Account',
            default          => $this->method,
        };
    }

    public function formattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
