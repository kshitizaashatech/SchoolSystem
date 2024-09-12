<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkSheetDesign extends Model
{
    use HasFactory;
    protected $table = "mark_sheet_designs";
    protected $fillable = ['school_id', 'template', 'heading', 'title', 'exam_name', 'left_logo', 'right_logo', 'school_name', 'exam_center', 'exam_session', 'left_sign', 'right_sign', 'middle_sign', 'background_img', 'date', 'is_classteacher_remarks', 'is_name', 'is_father_name', 'is_mother_name', 'is_dob', 'is_admission_no', 'is_roll_no', 'is_address', 'is_gender', 'is_division', 'is_rank', 'is_custom_field', 'content', 'is_photo', 'is_class', 'is_session', 'content_footer', 'is_active'];

    // Inside the MarkSheetDesign model

    public function generateMarkSheet($student)
    {
        // Retrieve mark sheet template (for example, from a database field or a stored file)
        $template = $this->template; // Assuming 'template' is the field name containing the mark sheet template content

        // Populate template with student data
        $markSheetContent = str_replace(
            ['{{student_name}}', '{{class}}', '{{roll_no}}'],
            [$student->name, $student->class, $student->roll_no],
            $template
        );

        // Apply design elements (formatting, styling, etc.)
        // Example: Apply CSS styles to the mark sheet content

        // Generate final mark sheet content
        return $markSheetContent;
    }

    public function examSchedule()
    {
        return $this->hasOne(ExamSchedule::class);
    }
}
