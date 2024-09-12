<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Classg;

class SubjectGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_group_name',
        'is_active',
        'school_id'
    ];

    protected $with = ['subjects'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_group_subject', 'subject_group_id', 'subject_id');
    }
    public function classes()
    {
        return $this->belongsToMany(Classg::class, 'subject_group_class', 'subject_group_id', 'class_id');
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'subject_group_section', 'subject_group_id', 'section_id');
    }
}
