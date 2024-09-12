<?php

namespace App\Models;

use App\Models\Income;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeHead extends Model
{
    use HasFactory;
    protected $table = 'incomeheads';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
    public function incomes()
    {
        return $this->hasMany(Income::class, 'incomehead_id');
    }
}
