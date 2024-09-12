<?php

namespace App\Models;

use App\Models\Classg;
use App\Models\FeeDue;
use App\Models\Section;
use App\Models\AcademicSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignClassTeacher extends Model
{
    use HasFactory;
    protected $table = 'assign_class_teachers';
    protected $fillable = [
        'academic_session_id',
        'class_id',
        'section_id',
        // 'class_teacher_id',
        'is_active'
    ];
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }
    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

   
}
