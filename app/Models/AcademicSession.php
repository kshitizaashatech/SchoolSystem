<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    protected $fillable = ['session', 'is_active', 'from_date', 'to_date'];
    public function academicManagement()
    {
        return $this->hasMany(AssignClassTeacher::class, 'academic_session_id');
    }
}