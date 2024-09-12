<?php

namespace App\Http\Services;

use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\ExamStudent;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentSession;
use Illuminate\Support\Facades\DB;

class ExamResultService
{
    public function getStudentResultsBySubject($examinations, $studentId = null)
    {
        $results = StudentSession::with(['user', 'student', 'examStudents', 'examStudents.examResult'])
            ->join('users', 'student_sessions.user_id', '=', 'users.id')
            ->join('classes', 'classes.id', '=', 'student_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'student_sessions.section_id')
            ->join('students', 'student_sessions.user_id', '=', 'students.user_id')
            ->join('exam_students', 'student_sessions.id', '=', 'exam_students.student_session_id')
            ->leftJoin('exam_results', function ($join) use ($examinations) {
                $join->on('student_sessions.id', '=', 'exam_results.student_session_id')
                    // ->where('exam_results.subject_id', $subjectId)
                    ->where('exam_results.exam_schedule_id', $examinations->id);
            })
            ->select('student_sessions.id', 'student_sessions.user_id', 'student_sessions.id as student_session_id', 'student_sessions.class_id as class_id', 'student_sessions.section_id as section_id', 'student_sessions.academic_session_id as academic_session_id', 'student_sessions.school_id as school_id', 'classes.class', 'sections.section_name', 'students.id as student_id', 'students.roll_no', 'students.admission_no', 'users.f_name', 'users.m_name', 'users.l_name', 'users.father_name', 'users.mother_name', 'users.gender', 'users.dob', 'exam_results.attendance', 'exam_results.participant_assessment', 'exam_results.practical_assessment', 'exam_results.theory_assessment', 'exam_results.notes', 'exam_results.subject_id', 'exam_students.id as exam_student_id', 'exam_students.examination_id')
            ->where('student_sessions.school_id', session('school_id'))
            ->where('student_sessions.academic_session_id', session('academic_session_id'))
            ->where('exam_students.examination_id', $examinations->id);
        if ($studentId) {
            $results->where('students.id', $studentId);
            return $results->first();
        }
        return $results->get();
    }

    // public function getStudentsQuery($classId = null, $sectionId = null)
    // {

    //     $query = Student::query()
    //         ->join('classes', 'students.class_id', '=', 'classes.id')
    //         ->join('sections', 'students.section_id', '=', 'sections.id')
    //         ->select('students.*', 'classes.class', 'sections.section_name');

    //     if ($classId) {
    //         $query->where('students.class_id', $classId);
    //     }

    //     if ($sectionId) {
    //         $query->where('students.section_id', $sectionId);
    //     }

    //     return $query;
    // }
}