<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['province_id', 'name, name_np'];

    /**
     * Getting the users belonging to this district.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
