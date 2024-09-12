<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\Examination;
use App\Models\ExamStudent;
use Illuminate\Http\Request;
use App\Models\StudentSession;
use App\Http\Services\FormService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExaminationStudentsController extends Controller
{
    protected $formService;
    //
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }
    public function index()
    {
        // $page_title = "List Examination";
        // return view('backend.school_admin.examination.index', compact('page_title'));
    }

    public function store(Request $request)
    {
        // $validatedData = Validator::make($request->all(), [
        //     // 'school_id' => 'filled|numeric',
        //     'exam' => 'required|string',
        //     'is_publish' => 'boolean',
        //     'is_rank_generated' => 'boolean',
        //     'is_active' => 'boolean',
        //     'description' => 'required|string',
        // ]);
        // if ($validatedData->fails()) {

        //     return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        // }

        // try {
        //     $examination = $request->all();

        //     $savedData = Examination::Create($examination);
        //     return redirect()->back()->withToastSuccess('Examination Saved Successfully!');
        // } catch (\Exception $e) {
        //     return back()->withToastError($e->getMessage());
        // }
    }

    public function edit(string $id)
    {
        // $examination = Examination::find($id);

        // return view('backend.school_admin.examination.index', compact('examination'));
    }

    public function update(Request $request, string $id)
    {
        // $validatedData = Validator::make($request->all(), [
        //     // 'school_id' => 'filled|numeric',
        //     'exam' => 'required|string',
        //     'is_publish' => 'boolean',
        //     'is_rank_generated' => 'boolean',
        //     'is_active' => 'boolean',
        //     'description' => 'required|string',

        // ]);
        // if ($validatedData->fails()) {

        //     return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        // }

        // $examination = Examination::findorfail($id);
        // try {
        //     $data = $request->all();

        //     $updateNow = $examination->update($data);

        //     return redirect()->back()->withToastSuccess('Successfully Updated Examination!');
        // } catch (Exception $e) {
        //     return back()->withToastError($e->getMessage())->withInput();
        // }
        // return back()->withToastError('Cannot Update Examination Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        // $examination = Examination::find($id);
        // try {
        //     $updateNow = $examination->delete();
        //     return redirect()->back()->withToastSuccess('Examination has been Successfully Deleted!');
        // } catch (Exception $e) {
        //     $error_message = $e->getMessage();
        //     return back()->withToastError($e->getMessage());
        // }

        // return back()->withToastError('Something went wrong. please try again');
    }

    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        // $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        // return response()->json($sections);
    }

    // public function getAllMarksheets()
    // {
    //     $page_title = 'Print Marksheet';
    //     $classes = Classg::all();
    //     $marksheet_designs = MarkSheetDesign::all();
    //     return view('backend.school_admin.examination.print_marksheet', compact('page_title', 'classes', 'marksheet_designs'));
    // }

    public function getAllExaminations(Request $request)
    {
        $examination = $this->getForDataTable($request->all());

        return Datatables::of($examination)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($classmgt) {
            //     return $classmgt->school_id;
            // })
            ->addColumn('exam', function ($examination) {
                return $examination->exam;
            })

            ->addColumn('is_publish', function ($examination) {
                return $examination->is_publish == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('is_rank_generated', function ($examination) {
                return $examination->is_rank_generated == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('description', function ($examination) {
                return $examination->description;
            })
            ->addColumn('created_at', function ($examination) {
                return $examination->created_at->diffForHumans();
            })
            ->addColumn('status', function ($examination) {
                return $examination->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($examination) {
                return view('backend.school_admin.examination.partials.controller_action', ['examination' => $examination])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Examination::where(function ($query) use ($request) {
            if (isset($request->id)) {
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
        $page_title = "Assign Students To " . $examinations->exam;
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();


        // dd($teacherRole);



        return view('backend.school_admin.examination.student.create', compact('page_title', 'classes', 'examinations'));
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
    // public function showAssignStudentsForm(Request $request, $classId, $sectionId)
    // {
    //     // Fetch class and section details
    //     $className = Classg::find($classId)->name;
    //     $sectionName = Section::find($sectionId)->name;
    //     $examinationId = $request->input('examination_id'); // Get examination_id from request
    
    //     // Pass variables to the view
    //     return view('backend.school_admin.examination.student.create', compact('classId', 'sectionId', 'examinationId', 'className', 'sectionName'));
    // }


    public function saveAssignStudentsToExam(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'examination_id' => 'required|integer',
                'student_sessions' => 'required|array',
            ]);
    
            // Fetch students based on class and section
            $students = Student::where('class_id', $validatedData['class_id'])
                ->where('section_id', $validatedData['section_id'])
                ->with('user') // Assuming there's a relationship to fetch user details
                ->get();
    
            // Begin transaction
            DB::beginTransaction();
    
            foreach ($students as $student) {
                // Prepare data for exam student assignment
                $studentSession = [
                    'student_session_id' => $student->id,
                    'examination_id' => $validatedData['examination_id'],
                    'is_active' => 1,
                ];
    
                // Update or create the record in the ExamStudent table
                ExamStudent::updateOrCreate(
                    [
                        'student_session_id' => $student->id,
                        'examination_id' => $validatedData['examination_id'],
                    ],
                    $studentSession
                );
            }
    
            // Commit transaction
            DB::commit();
    
            // Return success response
            return response()->json(['message' => 'Assigned successfully'], 200);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();
            // Log the error for debugging
            Log::error('Error in saveAssignStudentsToExam: ' . $e->getMessage());
            // Return error response
            return response()->json(['error' => 'Error occurred while assigning exam. Please try again later.'], 500);
        }
    }

    public function studentSessionsToDelete($request)
    {
        $updatedStudentSessions = $request->input('student_sessions');
        $examination_id = $request->input('examination_id');

        // Your query to fetch the records
        $query = StudentSession::where('school_id', session('school_id'))
            ->where('academic_session_id', session('academic_session_id'))
            ->where('class_id', $request->input('class_id'))
            ->where('section_id', $request->input('section_id'))
            ->whereHas('examStudents', function ($examassignedStudentQuery) use ($examination_id, $updatedStudentSessions) {
                $examassignedStudentQuery->where('examination_id', $examination_id);
            });

        // Fetch the records
        $studentSessionsToDelete = $query->get();

        // Delete the fetched records along with related examStudents records
        $studentSessionsToDelete->each(function ($studentSession) use ($updatedStudentSessions) {
            $studentSession->examStudents()->whereNotIn('student_session_id', $updatedStudentSessions)->delete();
        });
    }
}
