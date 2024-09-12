<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchedule extends Model
{

    use HasFactory;
    protected $table = 'exam_schedules';
    protected $fillable = ['examination_id', 'subject_group_id', 'subject_id', 'section_id', 'class_id', 'exam_date', 'exam_time', 'exam_duration', 'room_no', 'full_marks', 'pass_marks', 'credit_hour', 'is_active'];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function subjectGroups()
    {
        return $this->belongsTo(SubjectGroup::class, 'subject_group_id', 'id');
    }
    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function markSheetDesign()
    {
        return $this->belongsTo(MarkSheetDesign::class);
    }
}
