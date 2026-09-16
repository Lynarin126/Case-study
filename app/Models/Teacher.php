<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'teacher_code',
        'first_name',
        'last_name',
        'first_name_latin',
        'last_name_latin',
        'gender',
        'phone',
        'email',
        'specialization',
        'hire_date',
        'status',
        'address',
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

        return $khmer ?: $latin;
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
              ->orWhere('teacher_code', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');
    }
}
