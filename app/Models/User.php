<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Set password attribute with hashing
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is dokter
     */
    public function isDokter(): bool
    {
        return $this->role === 'dokter';
    }

    /**
     * Check if user is laboratorium
     */
    public function isLaboratorium(): bool
    {
        return $this->role === 'laboratorium';
    }

    /**
     * Check if user is kasir
     */
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * Get user's display role
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'dokter' => 'Dokter',
            'laboratorium' => 'Staff Laboratorium',
            'kasir' => 'Kasir',
            default => 'User'
        };
    }

    /**
     * Scope for admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for doctors
     */
    public function scopeDokters($query)
    {
        return $query->where('role', 'dokter');
    }

    /**
     * Scope for laboratory staff
     */
    public function scopeLaboratorium($query)
    {
        return $query->where('role', 'laboratorium');
    }

    /**
     * Scope for cashiers
     */
    public function scopeKasir($query)
    {
        return $query->where('role', 'kasir');
    }
}