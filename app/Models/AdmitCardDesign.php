<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitCardDesign extends Model
{
    use HasFactory;
    protected $table = "admin_card_designs";
    protected $fillable = ['school_id', 'template', 'heading', 'title', 'exam_name', 'left_logo', 'right_logo', 'school_name', 'exam_center', 'sign', 'background_img', 'is_name', 'is_father_name', 'is_mother_name', 'is_dob', 'is_admission_no', 'is_roll_no', 'is_address', 'is_gender', 'is_photo', 'is_class', 'is_session', 'content_footer', 'is_active'];
}
