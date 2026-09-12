<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $primaryKey = 'academic_year_id';

    protected $fillable = [
        'year_name',
        'start_date',
        'end_date',
        'is_active',
    ];
}
