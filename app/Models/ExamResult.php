<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
    protected $table = 'exam_results';
    protected $fillable = [
        'student_session_id', 
        'exam_student_id', 
        'exam_schedule_id', 
        'subject_id', 
        'attendance', 
        'participant_assessment', 
        'practical_assessment', 
        'theory_assessment', 
        'notes', 
        'is_active'
    ];

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id', 'id');
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function examStudent()
    {
        return $this->belongsTo(ExamStudent::class, 'exam_student_id', 'id');
    }

}