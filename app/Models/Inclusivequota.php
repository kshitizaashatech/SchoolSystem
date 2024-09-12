<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inclusivequota extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'priority', 'is_active'];
}
