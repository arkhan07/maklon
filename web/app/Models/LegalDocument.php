<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegalDocument extends Model
{
    protected $fillable = [
        'user_id', 'type', 'file_path', 'original_name',
        'status', 'notes', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'akta'  => 'Akta Pendirian',
            'nib'   => 'NIB (Nomor Induk Berusaha)',
            'siup'  => 'SIUP',
            'ktp'   => 'KTP Direktur',
            'npwp'  => 'NPWP Perusahaan',
            default => ucfirst($this->type),
        };
    }
}
