<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadTeacherLog extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'head_teacher_id', 'major_incidents', 'major_work_observation', 'assembly_management', 'miscellaneous', 'logged_date'];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}