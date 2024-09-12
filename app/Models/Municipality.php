<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable = ['district_id', 'name', 'name_np', 'wards'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
