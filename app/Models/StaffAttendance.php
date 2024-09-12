<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    use HasFactory;
    protected $table = 'staff_attendances';


    protected $fillable = [
        'biometric_attendance', 'attendance_type_id', 'date', 'remarks', 'is_active', 'school_id', 'staff_id'
    ];

    // public function staffs()
    // {
    //     return $this->hasMany(Staff::class, 'staff_id');
    // }


    public function staff() {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
