<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academic_session_id',
        'school_id',
        'class_id',
        'section_id',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
    public function classg()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }

    
    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class, 'student_session_id');
    }
    public function examStudents()
    {
        return $this->hasMany(ExamStudent::class, 'student_session_id');
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }
    public function examSchedule()
    {
        return $this->hasMany(ExamSchedule::class);
    }

    public function GPACalculation()
    {
        $examStudent = ExamStudent::where('student_session_id', $this->id)->where('examination_id', $this->examination_id)->first();

        if ($examStudent) {
            $examResults = $examStudent->examResult;

            $sum = 0;
            $totalCreditHours = 0;

            foreach ($examResults as $examResult) {
                // Access the related exam schedule
                $examSchedule = $examResult->examSchedule;

                if ($examSchedule) {
                    $subject_wise_exam_result = $this->SubjectWiseExamResults($examStudent->examination, $examSchedule->subject_id, $this);


                    // Add the product of gdp and credit_hour to the sum
                    $sum += isset($subject_wise_exam_result['grade'])
                        ? $subject_wise_exam_result['grade']->grade_points_to * $examSchedule->credit_hour
                        : 0;

                    // Increment total credit hours
                    $totalCreditHours += $examSchedule->credit_hour;
                }
            }

            // Calculate the weighted average
            if ($totalCreditHours > 0) {
                $gpa = $sum / $totalCreditHours;
            } else {
                // Handle the case where total credit hours is zero to avoid division by zero
                $gpa = 0;
            }

            return $gpa;
        }
    }

    // public function examResults($routine, $studentSession)
    // {
    //     return ExamResult::where('exam_student_id', $studentSession->exam_student_id)
    //         ->where('student_session_id', $studentSession->student_session_id)
    //         ->where('subject_id', $routine->id)->first();
    // }
    public function SubjectWiseExamResults($examinations, $subjectId, $studentSession)
    {
        if ($examinations->exam_type == "terminal") {
            return $this->generateTerminalExamResultBySubject($subjectId, $studentSession);
        } else {
            return $this->generateFinalExamResultBySubject($examinations, $subjectId, $studentSession);
        }
    }

    public function generateTerminalExamResultBySubject($subject_id, $studentSession)
    {
        $examResult = ExamResult::where('exam_student_id', $studentSession->exam_student_id)
            ->where('student_session_id', $studentSession->student_session_id)
            ->where('subject_id', $subject_id)->first();
        $partial_sum = 0;
        if ($examResult) {
            $partial_sum = $examResult->participant_assessment + $examResult->practical_assessment + $examResult->theory_assessment;
            $examResult->partial_sum = $partial_sum;
        }
        $percentage_calculation = $this->calculatePercentage($partial_sum, $total = 50);
        // Find the grade where the given percentage lies between percentage_from and percentage_to
        $grade = $this->gradeDetails($percentage_calculation);

        return [
            'grade' => $grade,
            'examResult' => $examResult
        ];
    }
    public function generateFinalExamResultBySubject($examinations, $subject_id, $studentSession)
    {
        $creditHour = ExamSchedule::where('examination_id', $studentSession->examination_id)
            ->where('class_id', $studentSession->class_id)
            ->where('section_id', $studentSession->section_id)
            ->where('subject_id', $subject_id)->first();

        $examResult = ExamResult::where('exam_student_id', $studentSession->exam_student_id)
            ->where('student_session_id', $studentSession->student_session_id)
            ->where('subject_id', $subject_id)->first();
        $sumOfInternalMarks = 0;
        $total_terminal_final_marks = 0;
        if ($examResult) {
            //sum of terminal exam after converted to 5
            $convertTenToFiveFromTerminalExams = $this->SumOfConveredTenToFiveFromTerminalExams($examinations, $subject_id, $studentSession);

            $sumOfInternalMarks = $examResult->participant_assessment + $examResult->practical_assessment + $convertTenToFiveFromTerminalExams;
            $examResult->internal_total = $sumOfInternalMarks;

            //calculation of internal exam grade
            $internalExamPercentage = $this->calculatePercentage($sumOfInternalMarks, $total = 50);
            $internalGrade = $this->gradeDetails($internalExamPercentage);

            //assign inteernal grade in examresult
            $examResult->internal_grade_point = $internalGrade->grade_points_to;
            $examResult->internal_grade_name = $internalGrade->grade_name;

            //calculation of external exam grade
            $externalExamPercentage = $this->calculatePercentage($examResult->theory_assessment, $total = 50);
            $externalGrade = $this->gradeDetails($externalExamPercentage);

            //assign in examresult
            $examResult->external_grade_point = $externalGrade->grade_points_to;
            $examResult->external_grade_name = $externalGrade->grade_name;


            $total_terminal_final_marks = ($examResult->theory_assessment + $sumOfInternalMarks);
            $examResult->total_terminal_final_marks = $total_terminal_final_marks;
        }
        $percentage_calculation = $this->calculatePercentage($total_terminal_final_marks, $total = 100);
        // Find the grade where the given percentage lies between percentage_from and percentage_to
        $grade = $this->gradeDetails($percentage_calculation);

        return [
            'grade' => $grade,
            'examResult' => $examResult,
            'creditHour' => $creditHour
        ];
    }
    public function SumOfConveredTenToFiveFromTerminalExams($examinations, $subject_id, $studentSession)
    {
        $totalMarksOfTerminalExamination = 0;
        foreach ($examinations->finalTerminalExaminations as $exams) {
            //get exam students
            $examStudent = ExamStudent::where('examination_id', $exams->id)->where('student_session_id', $studentSession->student_session_id)->first();

            //find the results of particular student
            $examResult = ExamResult::where('exam_student_id', $examStudent->id)
                ->where('student_session_id', $studentSession->student_session_id)
                ->where('subject_id', $subject_id)->first();

            $totalMarksOfTerminalExamination += (isset($examResult->theory_assessment) ? ($examResult->theory_assessment / 2) : 0);

        }
        return $totalMarksOfTerminalExamination;
    }
    public function calculatePercentage($partial, $total, $precision = 2)
    {
        if ($total == 0) {
            return 0;
        }

        return round(($partial / $total) * 100, $precision);
    }

    public function gradeDetails($percentage_calculation)
    {
        $grade = MarksGrade::where('percentage_from', '<=', $percentage_calculation)
            ->where('percentage_to', '>=', $percentage_calculation)
            ->first();

        // Check if grade exists
        if ($grade) {
            // Add the calculated percentage to the grade object
            $grade->calculated_percentage = $percentage_calculation;
        }
        return $grade;
    }
}