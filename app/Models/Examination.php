<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;
    protected $table = 'examinations';
    protected $fillable = ['exam', 'is_publish', 'exam_type', 'is_rank_generated', 'description', 'is_active', 'session_id', 'school_id'];

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }

    public function finalTerminalExaminations()
    {
        return $this->belongsToMany(Examination::class, 'final_term_examinations', 'final_examination_id', 'terminal_examination_id');
    }
    public function subjectByRoutine()
    {
        return $this->hasManyThrough(
            Subject::class, // Target model
            ExamSchedule::class, // Intermediate model
            'examination_id', // Foreign key on the intermediate model (ExamSchedule)
            'id', // Foreign key on the target model (Examination)
            'id', // Local key on this model (Examination)
            'subject_id' // Local key on the intermediate model (ExamSchedule)
        )->distinct('subjects.id');
    }
}