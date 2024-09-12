<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryExamination extends Model
{
    use HasFactory;
    protected $table  = 'primary_examinations';

    protected $fillable = ['exam', 'is_publish', 'is_rank_generated', 'description', 'is_active', 'session_id', 'school_id'];
}
