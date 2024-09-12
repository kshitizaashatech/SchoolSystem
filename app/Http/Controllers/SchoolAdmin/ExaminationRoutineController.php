<?php

namespace App\Http\Controllers\SchoolAdmin;

use Log;
use Validator;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\Examination;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExaminationRoutineController extends Controller
{
    protected $formService;
    //
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createExamRoutine(string $id)
    {
        $page_title = "Create Exam Routine";
        $examinations = Examination::find($id);
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.examination.routine.create', compact('page_title', 'classes', 'examinations'));
    }

    public function storeExamRoutine(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'subject_group_id' => 'required|exists:subject_groups,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'exam_date' => 'required',
            'exam_time' => 'required',
            'exam_duration' => 'required',
            'room_no' => 'nullable',
            'full_marks' => 'required',
            'pass_marks' => 'required',
            'credit_hour' => 'required',
        ]);

        try {
            // Process each subject's exam details
            foreach ($request->exam_date as $key => $examDate) {
                $subjectExamData = [
                    'examination_id' => $request->examination_id,
                    'subject_id' => $request->subject_id[$key],
                    'subject_group_id' => $request->subject_group_id[$key],
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'exam_date' => $examDate,
                    'exam_time' => $request->exam_time[$key],
                    'exam_duration' => $request->exam_duration[$key],
                    // 'room_no' => $request->room_no[$key],
                    'full_marks' => $request->full_marks[$key],
                    'pass_marks' => $request->pass_marks[$key],
                    'credit_hour' => $request->credit_hour[$key],
                    // Add other fields as needed
                ];

                // Create and save the ExamSchedule instance for each subject
                $examSchedule = new ExamSchedule();
                $examSchedule->fill($subjectExamData);
                $examSchedule->save();
            }

            return redirect()->back()->withToastSuccess('Exam Schedules created successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function editExamRoutine($id)
    {
        $page_title = "Edit Examination Routine";
        $routine = ExamSchedule::findOrFail($id);
        $classId = $routine->class_id;
        $className = $routine->classes->class;

        $sectionId = $routine->section_id;
        $sectionName = $routine->sections->section_name;


        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.examination.routine.update', compact('routine', 'schoolId', 'classes', 'page_title', 'className', 'sectionName'));
    }

    public function updateExamRoutine(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'subject_group_id' => 'required|exists:subject_groups,id',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id', // Validate each subject_id individually
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'exam_date' => 'required|array',
            'exam_time' => 'required|array',
            'exam_duration' => 'required|array',
            'room_no' => 'nullable|array',
            'full_marks' => 'required|array',
            'pass_marks' => 'required|array',
            'credit_hour' => 'required|array',
        ]);

        try {
            // Loop through each subject_id
            foreach ($request->subject_id as $key => $subjectId) {
                // Find the Exam Schedule with the matching attributes
                $examSchedule = ExamSchedule::where('subject_group_id', $request->subject_group_id[$key])
                    ->where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('subject_id', $subjectId)
                    ->firstOrFail();

                // Update the fields
                $examSchedule->examination_id = $request->examination_id;
                $examSchedule->exam_date = $request->exam_date[$key];
                $examSchedule->exam_time = $request->exam_time[$key];
                $examSchedule->exam_duration = $request->exam_duration[$key];
                // $examSchedule->room_no = $request->room_no[$key];
                $examSchedule->full_marks = $request->full_marks[$key];
                $examSchedule->pass_marks = $request->pass_marks[$key];
                $examSchedule->credit_hour = $request->credit_hour[$key];

                // Save the changes
                $examSchedule->save();
            }

            return redirect()->back()->withToastSuccess('Exam Routines updated successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function destroyExamRoutine($id)
    {
        // Find the exam schedule by ID
        $examSchedule = ExamSchedule::findOrFail($id);

        // Get the class ID, section ID, and subject group ID of the exam schedule
        $classId = $examSchedule->class_id;
        $sectionId = $examSchedule->section_id;
        $subjectGroupId = $examSchedule->subject_group_id;

        // Delete all exam schedules within the same group
        ExamSchedule::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->where('subject_group_id', $subjectGroupId)
            ->delete();

        // Redirect back with a success message
        return redirect()->back()->withToastSuccess('Exam schedules deleted successfully.');
    }

    public function getAllRoutines(Request $request, $id)
    {
        $examinations = Examination::find($id);
        $routines = $this->getForDataTable($request, $examinations->id);

        return Datatables::of($routines)
            ->escapeColumns([])
            ->addColumn('id', function ($routine) {
                return $routine->id;
            })
            ->addColumn('class_name', function ($routine) {
                return $routine->class_name;
            })
            ->addColumn('section_name', function ($routine) {
                return $routine->section_name;
            })
            ->addColumn('subject_group_id', function ($routine) {
                return $routine->subject_group_id;
            })
            ->addColumn('actions', function ($routine) use ($examinations) {
                // dd($examinations);
                // dd($routine);
                return view('backend.school_admin.examination.routine.partials.controller_action', [
                    'routine' => $routine,
                    'examinations' => $examinations,
                ])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request, $examinationId)
    {
        $dataTableQuery = ExamSchedule::leftJoin('classes', 'exam_schedules.class_id', '=', 'classes.id')
            ->leftJoin('sections', 'exam_schedules.section_id', '=', 'sections.id')
            ->select('exam_schedules.id', 'class_id', 'section_id', 'subject_group_id', 'classes.class as class_name', 'sections.section_name')
            ->where('examination_id', $examinationId);

        $data = $dataTableQuery->get()->unique(function ($item) {
            return $item['class_id'] . $item['section_id'] . $item['subject_group_id'];
        });

        return $data;
    }


    public function getStudentsByClassSection($class_id, $section_id)
{
    $students = Student::where('class_id', $class_id)
        ->where('section_id', $section_id)
        ->with('user') // Assuming there's a relationship to fetch user details
        ->get();

    return response()->json($students);
}

public function assignStudentsForExamRoutine($exam_id, $routine_id)
{
    $examinations = Examination::find($exam_id);
    $routines = ExamSchedule::find($routine_id);
    $examinationId=$examinations->id;
    

    $classId = $routines->class_id;
    $className = $routines->classes->class;
    
    $sectionId = $routines->section_id;
    $sectionName = $routines->sections->section_name;
    $page_title = "Assign Students To " . $examinations->exam;

    return view('backend.school_admin.examination.routine.exam_student.create', compact('page_title', 'examinations', 'routines', 'classId', 'className', 'sectionId', 'sectionName','examinationId'));
}

    public function assignStudentsForExamResult($exam_id, $routine_id)
    {
        $examinations = Examination::find($exam_id);
        $routines = ExamSchedule::find($routine_id);

       
        $page_title = "Assign Students To " . $examinations->exam;

        $classId = $routines->class_id;
        $className = $routines->classes->class;

        $sectionId = $routines->section_id;
        $sectionName = $routines->sections->section_name;
        // $subjectName = $routines->subject->subject;
        $examSchedule = $routines->id;
        // dd($examSchedule);

        return view('backend.school_admin.examination.routine.exam_result.create', compact('page_title', 'examinations', 'routines', 'classId', 'className', 'sectionId', 'sectionName', 'examSchedule'));
    }
}
