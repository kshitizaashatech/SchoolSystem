<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksGrade extends Model
{
    use HasFactory;
    protected $table = "marks_grades";
    protected $fillable = ['grade_name','grade_points','percentage_from','percentage_to','achievement_description','is_active'];
}