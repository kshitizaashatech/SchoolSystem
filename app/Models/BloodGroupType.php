<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroupType extends Model
{
    use HasFactory;
    protected $table = 'bloodgroup_types';
    protected $fillable = ['type'];
}
