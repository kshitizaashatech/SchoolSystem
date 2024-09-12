<?php

namespace App\Models;

use App\Models\InventoryHead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = [
        'school_id',
        'inventory_head_id',
        'name',
        'unit',
        'description',
        'status',
    ];
    public function inventoryHead()
    {
        return $this->belongsTo(InventoryHead::class, 'inventory_head_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
