<?php

namespace App\Models;

use App\Models\Expensehead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'expensehead_id',
        'name',
        'invoice_number',
        'date',
        'amount',
        'description',
        'document',
        'is_active',
    ];
    public function expenseHead()
    {
        return $this->belongsTo(Expensehead::class, 'expensehead_id');
    }
}
