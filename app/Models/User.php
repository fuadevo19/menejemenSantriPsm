<?php

namespace App\Models;

use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasName
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Otomatis hash password saat diisi.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value)
            ? bcrypt($value)
            : $value;
    }

    /**
     * Untuk tampilan nama user di Filament.
     */
    public function getFilamentName(): string
    {
        return $this->name ?? $this->username ?? 'User';
    }

    public function getUserName(): string
    {
        return (string) ($this->name ?: $this->username ?: 'User');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
