<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Models\ExamSchedule;
use App\Models\ExamStudent;
use App\Models\Subject;
use Validator;
use App\Models\Classg;
use App\Models\ExamResult;
use App\Models\StudentSession;
use App\Models\Examination;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Services\ExamResultService;
use App\Imports\CombinedImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExamResultExport;
use Illuminate\Support\Facades\Log;

class GenerateResultController extends Controller
{
    protected $examResultService;
    public function __construct(ExamResultService $examResultService)
    {
        $this->examResultService = $examResultService;
    }
    //
    public function index(string $id)
    {
        $examinations = Examination::find($id);
        $page_title = "Generate Result Of " . $examinations->exam;

        $studentSessions = $this->generateExamResult($examinations);

        return view('backend.school_admin.exam_result.index', compact('page_title', 'examinations', 'studentSessions'));
    }

    public function create(string $id)
    {
        Log::info('Entering create method with id: ' . $id);
    
        $examinations = Examination::with('subjectByRoutine')->findOrFail($id);
        $page_title = "Generate Result Of " . $examinations->exam;
    
        Log::info('Fetching student sessions');
        $studentSessions = StudentSession::with(['student.user', 'classg', 'section'])
            ->whereHas('examResults', function ($query) use ($id) {
                $query->whereHas('examSchedule', function ($q) use ($id) {
                    $q->where('examination_id', $id);
                });
            })
            ->get();
    
        Log::info('Student sessions count: ' . $studentSessions->count());
    
        Log::info('Fetching exam results');
        $examResults = ExamResult::with(['examSchedule.subject'])
            ->whereHas('examSchedule', function ($query) use ($id) {
                $query->where('examination_id', $id);
            })
            ->get();
    
        // Restructure exam results for easier access
        $restructuredResults = [];
        foreach ($examResults as $result) {
            $studentSessionId = $result->student_session_id;
            $subjectId = $result->examSchedule->subject_id;
            $restructuredResults[$studentSessionId][$subjectId] = $result;
        }
    
        Log::info('Exam results count: ' . count($restructuredResults));
        Log::debug('Restructured exam results data: ' . json_encode($restructuredResults));
    
        if ($examinations->exam_type == "terminal") {
            return view('backend.school_admin.exam_result.index', compact('page_title', 'examinations', 'studentSessions', 'restructuredResults'));
        } else {
            return $this->createFinalExamResult($id, $page_title, $examinations, $studentSessions, $restructuredResults);
        }
    }
    
    public function createFinalExamResult(string $id, $page_title, $examinations, $studentSessions, $restructuredResults)
    {
      // For terminal examinations
        $firstTermResults = $this->getTermResults('terminal');
        // $secondTermResults = $this->getTermResults('terminal');

        Log::info('First term results count: ' . count($firstTermResults));
        // Log::info('Second term results count: ' . count($secondTermResults));
    
        return view('backend.school_admin.exam_result.final_exam_result', compact('page_title', 'examinations', 'studentSessions', 'restructuredResults', 'firstTermResults'));
    }
    
    private function getTermResults($examType)
    {
        Log::info('Fetching term results for exam type: ' . $examType);
    
        // Adjust the query to match the actual exam type value
        $termResults = ExamResult::with('examSchedule.examination')
            ->whereHas('examSchedule.examination', function ($query) use ($examType) {
                // Use the correct value "terminal" instead of "first_term" or "second_term"
                $query->where('exam_type', $examType);
            })
            ->get();
    
        Log::info('Term results fetched: ' . $termResults->count());
        Log::debug('Term results data: ' . json_encode($termResults));
    
        $restructuredTermResults = [];
        foreach ($termResults as $result) {
            $studentSessionId = $result->student_session_id;
            $subjectId = $result->examSchedule->subject_id;
            $restructuredTermResults[$studentSessionId][$subjectId] = $result;
        }
    
        Log::debug('Restructured term results data: ' . json_encode($restructuredTermResults));
    
        return $restructuredTermResults;
    }

    public function exportExamResults(string $id)
    {
        $examinations = Examination::find($id);
        $concatenatedString = str_replace(' ', '', $examinations);
        $concatenatedString = str_replace(' ', '', $examinations->exam);
        return Excel::download(new ExamResultExport($examinations), $concatenatedString . 'result.xlsx');
    }

    public function generateExamResult($examinations)
    {
        return $this->examResultService->getStudentResultsBySubject($examinations);
    }

    public function store(Request $request)
    {
        // $validatedData = Validator::make($request->all(), [
        //     // 'school_id' => 'filled|numeric',

        //     'attendance' => 'required|string',
        //     'marks' => 'required|string',
        //     'notes' => 'required|string',
        //     'is_active' => 'required|boolean',
        // ]);
        // if ($validatedData->fails()) {

        //     return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        // }

        // try {
        //     $exam_result = $request->all();
        //     $exam_result['student_id'] = 1;
        //     $exam_result['exam_schedule_id'] = 1;



        //     $savedData = ExamResult::Create($exam_result);
        //     return redirect()->back()->withToastSuccess('Exam Result Saved Successfully!');

        // } catch (\Exception $e) {
        //     return back()->withToastError($e->getMessage());
        // }
    }

    public function edit(string $id)
    {
        // $exam_result = ExamResult::find($id);

        // return view('backend.school_admin.exam_result.index', compact('exam_result'));
    }


    public function update(Request $request, string $id)
    {
        // $validatedData = Validator::make($request->all(), [
        //     'attendance' => 'required|string',
        //     'marks' => 'required|string',
        //     'notes' => 'required|string',
        //     'is_active' => 'required|boolean',

        // ]);
        // if ($validatedData->fails()) {

        //     return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        // }

        // $exam_result = ExamResult::findorfail($id);
        // try {
        //     $data = $request->all();
        //     $exam_result['student_id'] = 1;
        //     $exam_result['exam_schedule_id'] = 1;


        //     $updateNow = $exam_result->update($data);

        //     return redirect()->back()->withToastSuccess('Successfully Updated Exam Result!');
        // } catch (Exception $e) {
        //     return back()->withToastError($e->getMessage())->withInput();
        // }
        // return back()->withToastError('Cannot Update Exam Result Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        // $exam_result = ExamResult::find($id);

        // try {
        //     $updateNow = $exam_result->delete();
        //     return redirect()->back()->withToastSuccess('Exam Result has been Successfully Deleted!');
        // } catch (\Exception $e) {
        //     return back()->withToastError($e->getMessage());
        // }

        // return back()->withToastError('Something went wrong. Please try again');
    }

    // public function getAllExamResult(Request $request)
    // {
    //     $exam_result = $this->getForDataTable($request->all());

    //     return Datatables::of($exam_result)
    //         ->escapeColumns([])
    //         // ->addColumn('school_id', function ($subject) {
    //         //     return $subject->school_id;
    //         // })
    //         ->addColumn('attendance', function ($exam_result) {
    //             return $exam_result->attendance;
    //         })
    //         ->addColumn('rank', function ($exam_result) {
    //             return $exam_result->marks;
    //         })
    //         ->addColumn('notes', function ($exam_result) {
    //             return $exam_result->notes;
    //         })

    //         ->addColumn('created_at', function ($exam_result) {
    //             return $exam_result->created_at->diffForHumans();
    //         })
    //         ->addColumn('status', function ($exam_result) {
    //             return $exam_result->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
    //         })
    //         ->addColumn('actions', function ($exam_result) {
    //             return view('backend.school_admin.exam_result.partials.controller_action', ['exam_result' => $exam_result])->render();
    //         })

    //         ->make(true);
    // }

    public function getForDataTable($request)
    {
        $dataTableQuery = ExamResult::where(function ($query) use ($request) {
            if (isset ($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assignStudents(string $id)
    {
        $examinations = Examination::find($id);
        $page_title = "Store Students Marks To " . $examinations->exam;
        $classes = Classg::where('school_id', session('school_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.examination.results.create', compact('page_title', 'classes', 'examinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getRoutineDetails(Request $request)
    {
        $sectionId = $request->input('sections');
        $classId = $request->input('class_id');
        $examinationId = $request->input('examination_id');
        if ($sectionId && $classId && $examinationId) {
            $examSchedule = ExamSchedule::where('class_id', $classId)->where('section_id', $sectionId)->where('examination_id', $examinationId)->get();
            if ($examSchedule->isNotEmpty()) {
                return view('backend.school_admin.examination.results.ajax_subject', compact('examSchedule'));
            } else {
                return response()->json(['message' => 'No exam routine or schedule has been set yet!!!'], 400);
            }
        } else {
            // Handle the case where one or more parameters are missing
            return response()->json(['message' => 'Missing parameters'], 400);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getStudentsDetails(Request $request)
    {
        $sectionId = $request->input('section_id');
        $classId = $request->input('class_id');
        $subjectId = $request->input('subject_id');
        $examinationId = $request->input('examination_id');
        $examinationScheduleId = $request->input('examination_schedule_id');
        if ($sectionId && $classId && $examinationId) {
            $examStudent = $this->formService->getExamAssignStudentDetails($examinationId, $examinationScheduleId, $subjectId, $classId, $sectionId);

            // Check if any examStudents relationship is not empty
            if ($examStudent->isNotEmpty()) {
                // Iterate over each StudentSession instance
                foreach ($examStudent as $studentSession) {
                    // dd($studentSession);
                    if ($studentSession->examStudents->isNotEmpty()) {
                        return view('backend.school_admin.examination.results.ajax_student', compact('examStudent', 'examinationScheduleId', 'subjectId'));
                    } else {

                        return response()->json(['message' => 'Students has not been assigned for particular Examination!!!'], 400);
                    }
                }
            } else {
                return response()->json(['message' => 'No students found with the given search parameters!!!'], 400);
            }
        } else {
            // Handle the case where one or more parameters are missing
            return response()->json(['message' => 'Missing parameters'], 400);
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
                $storeMarks = [
                    'exam_schedule_id' => $exam_schedule_id,
                    'subject_id' => $subject_id,
                    'student_session_id' => isset($request->student_session_id[$key]) ? $request->student_session_id[$key] : '',
                    'attendance' => isset($request->attendance[$key]) ? 0 : 1,
                    'marks' => isset($request->marks[$key]) ? $request->marks[$key] : 0,
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

    public function getExamResults($examinationId)
{
    // Fetch the examination details
    $examinations = Examination::find($examinationId);

    // Fetch exam results for the given examination
    $examResults = ExamResult::whereHas('examSchedule', function ($query) use ($examinations) {
        $query->where('examination_id', $examinations->id);
    })->with(['studentSession', 'examStudent', 'examSchedule', 'subject'])
    ->get();

    return $examResults;
}

public function getExamResultsData(string $id)
{
    $examinations = Examination::find($id);
    $examResults = ExamResult::whereHas('examSchedule', function ($query) use ($examinations) {
        $query->where('examination_id', $examinations->id);
    })->with(['studentSession', 'examStudent', 'examSchedule', 'subject'])
    ->get()->groupBy('student_session_id');
    
    $studentSessions = StudentSession::all();

    $data = $studentSessions->map(function($studentSession) use ($examResults) {
        $results = [];
        if (isset($examResults[$studentSession->id])) {
            foreach ($examResults[$studentSession->id] as $subjectResult) {
                $results[] = [
                    'subject_id' => $subjectResult->subject_id,
                    'participant_assessment' => $subjectResult->participant_assessment ?? '-',
                    'practical_assessment' => $subjectResult->practical_assessment ?? '-',
                    'theory_assessment' => $subjectResult->theory_assessment ?? '-',
                    'total' => ($subjectResult->participant_assessment + $subjectResult->practical_assessment + $subjectResult->theory_assessment) ?? '-'
                ];
            }
        }
        
        return [
            'admission_no' => $studentSession->admission_no,
            'roll_no' => $studentSession->roll_no,
            'student_name' => $studentSession->f_name . ' ' . $studentSession->m_name . ' ' . $studentSession->l_name,
            'father_name' => $studentSession->father_name,
            'class_name' => $studentSession->class_name,
            'section_name' => $studentSession->section_name,
            'results' => $results
        ];
    });

    return response()->json($data);
}
}