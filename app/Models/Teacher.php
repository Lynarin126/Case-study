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
        'gender',
        'phone',
        'email',
        'specialization',
        'hire_date',
        'status',
        'address',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');
    }
}
