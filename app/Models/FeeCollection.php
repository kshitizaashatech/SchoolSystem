<?php

namespace App\Models;

use App\Models\Student;
use App\Models\FeeGroupType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'payment_mode_id',
        'fee_groups_types_id',
        'amount',
        'payed_on',
        'notes'
    ];


    public function feeGroupType()
    {
        return $this->belongsTo(FeeGroupType::class, 'fee_groups_types_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


}
