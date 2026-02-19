<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'business_type', 'password',
        'google_id', 'avatar', 'role', 'is_active',
        'verification_status', 'verification_notes', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token', 'google_id'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function legalityDocument(): HasOne
    {
        return $this->hasOne(LegalityDocument::class);
    }

    public function legalityPackage(): HasOne
    {
        return $this->hasOne(LegalityPackage::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_verifikasi', 'admin_produksi', 'admin_keuangan']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function canOrder(): bool
    {
        return $this->isVerified() && $this->is_active;
    }
}
