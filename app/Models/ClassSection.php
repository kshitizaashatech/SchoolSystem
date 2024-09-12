<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory;
    protected $fillable = ['class_id', 'section_id', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
