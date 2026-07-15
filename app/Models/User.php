<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'division',
        'position',
        'photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->photo_path ? asset('storage/'.$this->photo_path) : null,
        );
    }

    public function initials(): string
    {
        $words = collect(explode(' ', trim($this->name)))
            ->filter()
            ->take(2)
            ->map(fn (string $word): string => mb_substr($word, 0, 1));

        return $words->implode('') ?: 'K';
    }

    public function structureLabel(): string
    {
        return trim(collect([$this->division, $this->position])->filter()->implode(' • ')) ?: ucfirst($this->role);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function scopePeserta(Builder $query): Builder
    {
        return $query->where('role', 'peserta');
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }
}
