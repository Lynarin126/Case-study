<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_category_id',
        'course_code',
        'course_name',
        'description',
        'visibility',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id', 'course_category_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'teacher_id');
    }

    public function courseModules(): HasMany
    {
        return $this->hasMany(CourseModule::class, 'course_id', 'course_id')->orderBy('module_number');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(ContentLesson::class, 'course_id', 'course_id');
    }
}
