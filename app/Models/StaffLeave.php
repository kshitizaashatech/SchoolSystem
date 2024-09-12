<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'from_date',
        'to_date',
        'leave_type_id',
        'status',
        'docs',
        'reason',
        'approved_by',
        'apply_date',
        'approved_date',
        'leave_days',
        'remarks',
        'class_id',
        'section_id',
        'staff_id'
    ];


    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
    public function approved_user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function user()
    {
        return $this->staff->user();
    }
}