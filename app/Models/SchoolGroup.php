<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schools()
    {
        return $this->hasMany(School::class, 'group_id');
    }
}
