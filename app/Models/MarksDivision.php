<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksDivision extends Model
{
    use HasFactory;
    protected $table = "marks_divisions";
    protected $fillable = ['name','points','marks_from','marks_to','description','is_active'];
}
