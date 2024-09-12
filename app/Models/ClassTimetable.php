<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Classg;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SubjectGroup;
use App\Models\AcademicSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassTimetable extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'academic_session_id',
        // 'school_id',
        // 'class_id',
        // 'section_id',
        // 'subject_group_id',
        // 'subject_id',
        // 'staff_id',
        'day',
        'time_from',
        'time_to',
        'start_time',
        'end_time',
        'room_no',
        'is_active',
    ];
    // public function academicSession()
    // {
    //     return $this->belongsTo(AcademicSession::class);
    // }

    // public function school()
    // {
    //     return $this->belongsTo(School::class);
    // }

    // public function class ()
    // {
    //     return $this->belongsTo(Classg::class, 'class_id');
    // }

    // public function section()
    // {
    //     return $this->belongsTo(Section::class);
    // }

    // public function subjectGroup()
    // {
    //     return $this->belongsTo(SubjectGroup::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // public function staff()
    // {
    //     return $this->belongsTo(Staff::class);
    // }
}
