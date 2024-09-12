<?php

namespace App\Models;

use App\Models\FeeDue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
    ];
    // public function feeDues()
    // {
    //     return $this->hasMany(FeeDue::class, 'fee_groups_id');
    // }

}
