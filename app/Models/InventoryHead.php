<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHead extends Model
{
    use HasFactory;
    protected $table = 'inventory_head';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
    public function inventories()
    {
        return $this->hasMany(Income::class, 'inventory_head_id');
    }
}
