<?php

namespace App\Models;

use App\Models\IncomeHead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'incomehead_id',
        'name',
        'invoice_number',
        'date',
        'amount',
        'description',
        'document',
        'is_active',
    ];
    public function incomeHead()
    {
        return $this->belongsTo(IncomeHead::class, 'incomehead_id');
    }
}
