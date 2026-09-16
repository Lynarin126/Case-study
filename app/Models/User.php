<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'first_name_latin',
        'last_name_latin',
        'email',
        'password',
    ];

    public function getKhmerNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getLatinNameAttribute(): string
    {
        return trim("{$this->first_name_latin} {$this->last_name_latin}");
    }

    public function getFullNameAttribute(): string
    {
        $khmer = $this->khmer_name;
        $latin = $this->latin_name;

        if ($khmer && $latin && $khmer !== $latin) {
            return "{$khmer} ({$latin})";
        }

        return $khmer ?: ($latin ?: ($this->attributes['name'] ?? ''));
    }

    public function getNameAttribute(?string $value): string
    {
        $khmer = $this->khmer_name;
        $latin = $this->latin_name;

        if ($khmer && $latin && $khmer !== $latin) {
            return "{$khmer} ({$latin})";
        }

        return $khmer ?: ($latin ?: ($value ?? ''));
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('first_name_latin', 'like', "%{$term}%")
              ->orWhere('last_name_latin', 'like', "%{$term}%")
              ->orWhere('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function permissions(): array
    {
        return $this->roles()
            ->with('permissions:id,slug')
            ->get()
            ->flatMap(fn (Role $role) => $role->permissions->pluck('slug'))
            ->unique()
            ->values()
            ->all();
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return $this->roles()
            ->whereIn('slug', $roles)
            ->orWhereIn('name', $roles)
            ->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->where('slug', $permission))
            ->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->whereIn('slug', $permissions))
            ->exists();
    }

    public function hasAllPermissions(array $permissions): bool
    {
        return collect($permissions)->every(fn (string $permission) => $this->hasPermission($permission));
    }
}
