<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationTeachers extends Model
{
    use HasFactory;
    protected $fillable = ['examination_id', 'class_id', 'section_id', 'user_id', 'student_session_id'];
    protected $table = 'exam_teachers';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function class()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }
}
