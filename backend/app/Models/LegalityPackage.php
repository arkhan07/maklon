<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegalityPackage extends Model
{
    protected $fillable = [
        'user_id', 'package_type', 'price', 'payment_status',
        'payment_proof_url', 'verified_by', 'verified_at', 'activated_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'verified_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getPriceLabelAttribute(): string
    {
        return match ($this->package_type) {
            'pt_perorangan' => 'PT Perorangan',
            'pt_perseroan' => 'PT Perseroan',
            default => $this->package_type,
        };
    }
}
