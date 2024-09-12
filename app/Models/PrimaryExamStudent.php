<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryExamStudent extends Model
{
    use HasFactory;

    protected $table = 'primary_exam_students';

    protected $fillable = [
        'examination_id',
        'student_session_id',
        'teachers_remarks',
        'rank',
        'is_active'
    ];
}
