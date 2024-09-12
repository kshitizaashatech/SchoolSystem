<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'school_id', 
        'reservation_quota_id', 
        'admission_no', 
        'roll_no', 
        'admission_date', 
        'school_house_id', 
        'student_photo', 
        'guardian_is', 
        'guardian_name', 
        'guardian_relation', 
        'guardian_phone', 
        'guardian_email', 
        'transfer_certificate', 
        'class_id', 
        'section_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function schoolHouse()
    {
        return $this->belongsTo(SchoolHouse::class, 'school_house_id');
    }

    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function studentLeaves()
    {
        return $this->hasMany(StudentLeave::class, 'student_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'student_id');
    }

    public function session()
    {
        return $this->belongsTo(StudentSession::class);
    }

    public function feeCollections()
    {
        return $this->hasMany(FeeCollection::class);
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class, 'user_id');
    }
    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id');
    }
}
