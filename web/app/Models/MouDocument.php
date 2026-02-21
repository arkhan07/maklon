<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouDocument extends Model
{
    protected $fillable = [
        'order_id', 'generated_pdf', 'signed_pdf',
        'status', 'notes', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'            => 'Draft',
            'waiting_signature'=> 'Menunggu TTD',
            'signed_uploaded'  => 'Sudah Diupload',
            'approved'         => 'Disetujui',
            'rejected'         => 'Ditolak',
            default            => ucfirst($this->status),
        };
    }
}
