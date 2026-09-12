<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseModule extends Model
{
    protected $primaryKey = 'course_module_id';

    protected $fillable = [
        'course_id',
        'module_number',
        'title',
        'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(ContentLesson::class, 'course_module_id', 'course_module_id')->orderBy('position');
    }
}
