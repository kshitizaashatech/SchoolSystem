<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\Classg;
use App\Models\Subject;
use App\Models\ExamResult;
use App\Models\Examination;
use App\Models\ExamStudent;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use App\Models\StudentSession;
use App\Models\Student;
use App\Imports\CombinedImport;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Exports\ExamResultExport;

class ExamResultController extends Controller
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function destroy(string $id)
    {
        $exam_result = ExamResult::find($id);

        try {
            $exam_result->delete();
            return redirect()->back()->withToastSuccess('Exam Result has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function getAllExamResult(Request $request, $id)
    {
        $exam_results = $this->getForDataTable($request->all());

        return Datatables::of($exam_results)
            ->escapeColumns([])
            ->addColumn('attendance', fn($exam_result) => $exam_result->attendance)
            ->addColumn('rank', fn($exam_result) => $exam_result->marks)
            ->addColumn('notes', fn($exam_result) => $exam_result->notes)
            ->addColumn('created_at', fn($exam_result) => $exam_result->created_at->diffForHumans())
            ->addColumn('status', fn($exam_result) => $exam_result->is_active ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>')
            ->addColumn('actions', fn($exam_result) => view('backend.school_admin.exam_result.partials.controller_action', ['exam_result' => $exam_result])->render())
            ->make(true);
    }

    public function show($student_session_id)
{
    // Fetch all exam results for the student
    $examResults = ExamResult::where('student_session_id', $student_session_id)
                             ->with('subject')
                             ->get();

    // If you need to fetch student details from the student_session
    $studentSession = StudentSession::findOrFail($student_session_id);
    $student = $studentSession->student()->with('user')->first(); // Assuming you have a relationship defined
    if (!$student || !$student->user) {
        // Handle the case where student or user is not found
        return redirect()->back()->with('error', 'Student information not found');
    }

    // Combine first name and last name
    $studentName = $student->user->f_name . ' ' . $student->user->l_name;

    return view('backend.school_admin.examination.results.show', compact('examResults', 'student', 'studentName'));
}

    public function getForDataTable(array $request)
    {
        return ExamResult::when($request['id'] ?? null, fn($query, $id) => $query->where('id', $id))->get();
    }

    public function assignStudents(string $id)
    {
        $examinations = Examination::find($id);
        $page_title = "Store Students Marks To " . $examinations->exam;
        $classes = Classg::where('school_id', session('school_id'))->latest()->get();

        return view('backend.school_admin.examination.results.create', compact('page_title', 'classes', 'examinations'));
    }

    public function getRoutineDetails(Request $request)
    {
        $request->validate([
            'sections' => 'required',
            'class_id' => 'required',
            'examination_id' => 'required',
        ]);

        $examSchedule = ExamSchedule::where('class_id', $request->class_id)
            ->where('section_id', $request->sections)
            ->where('examination_id', $request->examination_id)
            ->get();

        if ($examSchedule->isEmpty()) {
            return response()->json(['message' => 'No exam routine or schedule has been set yet!!!'], 400);
        }

        return view('backend.school_admin.examination.results.ajax_subject', compact('examSchedule'));
    }

    public function getStudentsDetails(Request $request)
{
    try {
        $sectionId = $request->input('section_id');
        $classId = $request->input('class_id');
        $subjectId = $request->input('subject_id');
        $examinationId = $request->input('examination_id');
        $examinationScheduleId = $request->input('examination_schedule_id');
        
        Log::info('Input parameters:', $request->all());

        $subject = Subject::findOrFail($subjectId);
        $subjectName = $subject->subject;
        
        Log::info('Subject found:', ['id' => $subject->id, 'name' => $subjectName]);

        $examSchedule = ExamSchedule::findOrFail($examinationScheduleId);
        $fullMarks = $examSchedule->full_marks;

        $examStudents = ExamStudent::with([
                'studentSession.student', 
                'studentSession.student.user'
            ])
            ->where('examination_id', $examinationId)
            ->whereHas('studentSession', function ($query) use ($classId, $sectionId) {
                $query->where('class_id', $classId)
                      ->where('section_id', $sectionId);
            })
            ->get();

        Log::info('ExamStudent query results:', ['count' => $examStudents->count()]);

        return view('backend.school_admin.examination.results.ajax_student', compact('examStudents', 'examinationScheduleId', 'subjectId', 'subjectName', 'fullMarks'))
            ->render();

    } catch (\Exception $e) {
        Log::error('Error in getStudentsDetails: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}
    /**
     * Show the form for creating a new resource.
     */
    public function getExamAssignStudents($id, $classId, $sectionId)
    {
        $students = $this->formService->getExamAssignStudents($id, $classId, $sectionId);
        return response()->json($students);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function saveStudentsMarks(Request $request)
    {
        try {
            $exam_schedule_id = $request->input('exam_schedule_id');
            $subject_id = $request->input('subject_id');
            //store the records
            foreach ($request->student_id as $key => $studentId) {
                // Check if the checkbox is checked
                $attendanceValue = isset($request->attendance[$key]) ? $request->attendance[$key] : 1;
                $storeMarks = [
                    'exam_schedule_id' => $exam_schedule_id,
                    'subject_id' => $subject_id,
                    'student_session_id' => isset($request->student_session_id[$key]) ? $request->student_session_id[$key] : '',
                    'exam_student_id' => isset($request->exam_student_id[$key]) ? $request->exam_student_id[$key] : '',
                    'attendance' => $attendanceValue,
                    'participant_assessment' => isset($request->participant_assessment[$key]) ? $request->participant_assessment[$key] : 0,
                    'practical_assessment' => isset($request->practical_assessment[$key]) ? $request->practical_assessment[$key] : 0,
                    'theory_assessment' => isset($request->theory_assessment[$key]) ? $request->theory_assessment[$key] : 0,
                    'notes' => isset($request->notes[$key]) ? $request->notes[$key] : '',
                    'is_active' => 1
                ];
                // Update the record if it exists, otherwise create a new one
                ExamResult::updateOrCreate(
                    [
                        'exam_schedule_id' => $exam_schedule_id,
                        'student_session_id' => $request->student_session_id[$key]
                    ],
                    $storeMarks
                );
            }
            return back()->withToastSuccess('Marks successfully updated!!');
        } catch (\Exception $e) {
            return back()->withToastError('Error registering marks: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'exam_schedule_id' => 'required',
            'exam_id' => 'required',
            'file' => 'required|file|mimes:csv,txt',
        ]);

        DB::beginTransaction();
        try {
            $import = new CombinedImport($request->all());
            Excel::import($import, $request->file('file'));

            DB::commit();
            return back()->withToastSuccess('Excel successfully uploaded');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withToastError($e->getMessage());
        }
    }


    public function exportAll()
    {
        return Excel::download(new ExamResultExport(), 'all_students.xlsx');
    }

}
