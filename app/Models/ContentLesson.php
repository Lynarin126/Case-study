<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentLesson extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'content_lesson_id';

    protected $fillable = [
        'course_id',
        'course_module_id',
        'module_number',
        'module_title',
        'title',
        'slug',
        'content_type',
        'summary',
        'body',
        'external_url',
        'file_path',
        'video_url',
        'duration_minutes',
        'position',
        'available_from',
        'available_until',
        'completion_required',
        'visibility',
        'max_score',
        'passing_score',
        'allow_comments',
        'metadata',
        'is_published',
    ];

    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'completion_required' => 'boolean',
        'allow_comments' => 'boolean',
        'is_published' => 'boolean',
        'metadata' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function courseModule(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id', 'course_module_id');
    }
}
