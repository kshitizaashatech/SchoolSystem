<?php

namespace App\Http\Services;


use App, Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Staff;

use App\Models\State;
use App\Models\Topic;
use App\Models\Classg;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\District;
use App\Models\ExamSchedule;
use App\Models\Municipality;
use App\Models\PrimaryLessonMarks;
use App\Models\PrimaryMarks;
use App\Models\SubjectGroup;
use App\Models\StudentSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ExamStudent;

class FormService
{
    /**
     * @var User
     */
    protected $user;

    public function getProvinces()
    {
        return State::all();
    }

    public function getDistricts($provinceId)
    {
        return District::where('province_id', $provinceId)->get();
    }

    public function getMunicipalities($districtId)
    {
        return Municipality::where('district_id', $districtId)->get();
    }

    public function getWards($municipalityId)
    {
        $municipality = Municipality::find($municipalityId);

        if ($municipality) {
            // Decode the wards array from JSON
            $wardsArray = json_decode($municipality->wards, true);

            // Create an array of stdClass objects to match the expected response
            $wards = [];
            foreach ($wardsArray as $ward) {
                $wards[] = (object) ['id' => $ward, 'name' => "Ward $ward"];
            }

            return $wards;
        }

        return [];
    }

    public function getSubjectGroupByClassAndSections($request)
    {
        $sections = $request->input('sections', []);
        $classId = $request->input('class_id');

        $results = SubjectGroup::whereHas('classes', function ($query) use ($classId) {
            $query->where('class_id', $classId);
        })
            ->whereHas('sections', function ($query) use ($sections) {
                $query->whereIn('section_id', $sections);
            })
            ->get();
        return $results;
    }
    public function getLessonsGroupByClassSectionSubjectgroupAndSubject($request)
    {
        // dd($request->all());
        $sections = $request->input('sections');
        // dd($sections);
        $classId = $request->input('class_id');
        $subject_group_id = $request->input('subject_group_id');
        $subjectId = $request->input('subject_id');

        $results = Lesson::where('class_id', $classId)->whereIn('section_id', $sections)->where('subject_group_id', $subject_group_id)->where('subject_id', $subjectId)->get();

        return $results;
    }

    public function getLessonsGroupByClassSectionSubjectgroupAndSubjectPrimary($request)
    {
        // dd($request->all());
        $sections = $request->input('sections');
        // dd($sections);
        $classId = $request->input('class_id');
        $subject_group_id = $request->input('subject_group_id');
        $subjectId = $request->input('subject_id');

        $results = PrimaryLessonMarks::where('class_id', $classId)->whereIn('section_id', $sections)->where('subject_group_id', $subject_group_id)->where('subject_id', $subjectId)->get();

        return $results;
    }
    public function getTopicsByClassSectionSubjectgroupSubjectAndLesson($request)
    {
        $sections = $request->input('sections');
        // dd($sections);
        $classId = $request->input('class_id');
        $subject_group_id = $request->input('subject_group_id');
        $subjectId = $request->input('subject_id');
        $lessonId = $request->input('lesson_id');

        $results = Topic::where('class_id', $classId)->whereIn('section_id', $sections)->where('subject_group_id', $subject_group_id)->where('subject_id', $subjectId)->where('lesson_id', $lessonId)->get();

        return $results;
    }

    public function getLesson($request)
    {
        $sections = $request->input('section_id');
        // dd($sections);
        $classId = $request->input('class_id');
        $subject_group_id = $request->input('subject_group_id');
        $subjectId = $request->input('subject_id');

        return Lesson::where('class_id', $classId)->where('section_id', $sections)->where('subject_group_id', $subject_group_id)->where('subject_id', $subjectId)->get();
    }

    public function getSection($classId)
    {
        $schoolId = session('school_id');
        // return Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');

        return Classg::where('school_id', $schoolId)
            ->find($classId)
            ->sections()
            ->pluck('sections.section_name', 'sections.id');
    }

    public function getSubjectsBySubjectGroup($subject_group_id)
    {
        return SubjectGroup::findOrFail($subject_group_id)->subjects;
        ;
    }


    public function getStudentBySection($classId, $sectionId)
    {
        return StudentSession::with(['user', 'student'])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();
    }


    public function getStudentsBySection($classId, $sectionId, $date = null)
    {
        $query = StudentSession::with([
            'user',
            'student',
            'studentAttendances' => function ($attendanceQuery) use ($date) {
                // Add condition for the date in studentAttendances relationship
                if ($date) {
                    $attendanceQuery->where('date', $date);
                }
            }
        ])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId);

        $data = $query->get();
        // dd($data);
        return response()->json($data);
    }
    public function getStudentsByClassSection($classId, $sectionId, $date = null)
    {
        $query = StudentSession::with([
            'user',
            'student'
        ])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId);

        $data = $query->get();
        // dd($data);
        return response()->json($data);
    }
    public function getExamAssignStudents(Request $request)
{
    $sectionId = $request->input('section_id');
    $classId = $request->input('class_id');
    $subjectId = $request->input('subject_id');
    $examinationId = $request->input('examination_id');
    $examinationScheduleId = $request->input('examination_schedule_id');

    // Fetch the exam students details
    $examStudents = ExamStudent::with(['student', 'student.user'])
        ->whereHas('student', function ($query) use ($classId, $sectionId) {
            $query->where('class_id', $classId)
                  ->where('section_id', $sectionId);
        })
        ->where('subject_id', $subjectId)
        ->where('examination_id', $examinationId) 
        ->where('examination_schedule_id', $examinationScheduleId)
        ->get(); // Get the data here

    // Return the data as JSON
    return response()->json($examStudents);
}
 
public function getExamAssignStudentDetails($examination_id, $examinationScheduleId, $subjectId, $classId, $sectionId)
    {
        $data = StudentSession::with(['user', 'student', 'examStudents', 'examStudents.examResult'])
            ->join('users', 'student_sessions.user_id', '=', 'users.id')
            ->join('students', 'student_sessions.user_id', '=', 'students.user_id')
            ->join('exam_students', 'student_sessions.id', '=', 'exam_students.student_session_id')
            ->leftJoin('exam_results', function ($join) use ($subjectId, $examinationScheduleId) {
                $join->on('student_sessions.id', '=', 'exam_results.student_session_id')
                    ->where('exam_results.subject_id', $subjectId)
                    ->where('exam_results.exam_schedule_id', $examinationScheduleId);
            })
            ->select('student_sessions.id', 'student_sessions.user_id', 'student_sessions.id as student_session_id', 'student_sessions.class_id as class_id', 'student_sessions.section_id as section_id', 'student_sessions.academic_session_id as academic_session_id', 'student_sessions.school_id as school_id', 'students.admission_no', 'students.roll_no', 'students.admission_no', 'users.f_name', 'users.m_name', 'users.l_name', 'users.father_name', 'users.mother_name', 'users.gender', 'exam_results.attendance', 'exam_results.participant_assessment', 'exam_results.practical_assessment', 'exam_results.theory_assessment', 'exam_results.notes', 'exam_results.subject_id', 'exam_students.id as exam_student_id', 'exam_students.examination_id')
            ->where('student_sessions.school_id', session('school_id'))
            ->where('student_sessions.academic_session_id', session('academic_session_id'))
            ->where('student_sessions.class_id', $classId)
            ->where('student_sessions.section_id', $sectionId)
            ->where('exam_students.examination_id', $examination_id)
            ->whereHas('examStudents', function ($examassignedStudentQuery) use ($examination_id, $examinationScheduleId, $subjectId) {
                if ($examination_id) {
                    $examassignedStudentQuery->where('examination_id', $examination_id);
                }
                // if ($subjectId) {
                //     $examassignedStudentQuery->whereHas('examResult', function ($examStudentResultQuery) use ($examinationScheduleId, $subjectId) {
                //         $examStudentResultQuery->where('subject_id', $subjectId)->where('exam_schedule_id', $examinationScheduleId);
                //     });
                // }
    
                $examassignedStudentQuery->orWhereDoesntHave('examResult');
            });

        // dd($data->toRawSql());

        return $data->get();
    }

    public function getSubjectsBySubjectGroupId($subjectGroupId, $classId, $sectionId)
    {
        return ExamSchedule::with('subject')
            ->where('subject_group_id', $subjectGroupId)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();
    }
}