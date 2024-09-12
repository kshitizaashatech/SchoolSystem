<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamStudent extends Model
{
    use HasFactory;
    protected $table = 'exam_students';
    protected $fillable = ['examination_id', 'student_session_id', 'teachers_remarks', 'rank', 'is_active'];

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id', 'id');
    }
    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id', 'id');
    }

    // public function examResults()
    // {
    //     return $this->hasMany(ExamResult::class, 'subject_id');
    // }

    public function examResult()
    {
        return $this->hasMany(ExamResult::class);
    }
}