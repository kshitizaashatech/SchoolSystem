<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_date',
        'to_date',
        'status',
        'docs',
        'reason',
        'approved_by',
        'rejected_by',
        'approved_date',
        'remarks',
        'class_id',
        'section_id',
        'student_id'
    ];

    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function user()
    {
        return $this->student->user();
    }

    public function approved_user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}