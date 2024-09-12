<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Examination;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use App\Models\MarkSheetDesign;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\StudentUserService;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;


class ExaminationController extends Controller

{
    protected $formService;
    protected $studentUserService;

    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }

    protected function initializeSessionValues()
    {
        if (Auth::check()) {
            // Always fetch and set academic_session_id
            $academicSessionId = DB::table('academic_sessions')
                ->where('is_active', 1)
                ->value('id');
            if ($academicSessionId) {
                session(['academic_session_id' => $academicSessionId]);
                Log::info('Academic session ID set:', ['academic_session_id' => $academicSessionId]);
            } else {
                Log::error('No active academic session found.');
                throw new \Exception('No active academic session found.');
            }
    
            // Always fetch and set school_id
            $schoolId = Auth::user()->school_id;
            if ($schoolId) {
                session(['school_id' => $schoolId]);
                Log::info('School ID set:', ['school_id' => $schoolId]);
            } else {
                Log::error('User does not belong to any school.');
                throw new \Exception('User does not belong to any school.');
            }
        } else {
            Log::error('User is not authenticated.');
            throw new \Exception('User is not authenticated.');
        }
    }

    public function index()
    {
        $this->initializeSessionValues();
        $page_title = "List Examination";
        return view('backend.school_admin.examination.index', compact('page_title'));
    }

    public function store(Request $request)
    {
        try {
            $this->initializeSessionValues();

            // $academicSessionId = session('academic_session_id');
            // dd('Session ID:', $academicSessionId);
    
            $validatedData = Validator::make($request->all(), [
                'exam' => 'required|string',
                'date' => 'required|string',
                'exam_type' => 'required|string',
                'is_publish' => 'boolean',
                'is_rank_generated' => 'boolean',
                'is_active' => 'boolean',
                'description' => 'required|string',
                // 'session_id' => 'required|integer',
            ]);
    
            if ($validatedData->fails()) {
                return back()->withToastError($validatedData->messages()->first())->withInput();
            }
    
            $data = $validatedData->validated();
            $data['session_id'] = session('academic_session_id');
            $data['school_id'] = session('school_id');
    
            Examination::create($data);
    
            return redirect()->route('admin.examinations.index')->withToastSuccess('Examination Saved Successfully!');
        } catch (\Exception $e) {
            Log::error('Exception in storing examination:', ['error' => $e->getMessage()]);
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $this->initializeSessionValues();
        $examination = Examination::find($id);
        return view('backend.school_admin.examination.index', compact('examination'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'filled|numeric',
            'exam' => 'required|string',
            'date'=>'required|string',
            'is_publish' => 'boolean',
            'is_rank_generated' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'required|string',

        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $examination = Examination::findorfail($id);
        try {
            $data = $request->all();
            $data['session_id'] = session('academic_session_id');
            $data['school_id'] = session('school_id');
            $updateNow = $examination->update($data);
            //update the relationship
            if ($request->exam_type === 'final') {
                $validator = $this->validateTermExamination($request);
                if ($validator->fails()) {
                    return back()->withToastError($validator->messages()->all()[0])->withInput();
                }
                $final_terminal_exam_data = $examination->finalTerminalExaminations()->sync($request->input('term_exam'));
            }

            return redirect()->back()->withToastSuccess('Successfully Updated Examination!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Examination Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $examination = Examination::find($id);
        try {
            $updateNow = $examination->delete();
            return redirect()->back()->withToastSuccess('Examination has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }



    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        return response()->json($sections);
    }
    public function getTermExam($id = null)
    {
        $term_exams = Examination::where('session_id', session('academic_session_id'))
            ->where('school_id', session('school_id'))
            ->where('exam_type', 'terminal')
            ->when($id, function ($query) use ($id) {
                return $query->where('final_examination_id', $id);
            })
            ->pluck('exam', 'id');

        return response()->json($term_exams);
    }



    // public function showMarkSheetDesign($student_id, $class_id, $section_id, $marksheetdesign_id)
    // {
    //     $student = Student::with('user')->findOrFail($student_id);
    //     $class = Classg::findOrFail($class_id);
    //     $section = Section::findOrFail($section_id);
    //     $marksheet = MarkSheetDesign::findOrFail($marksheetdesign_id);

    //     // Fetch exam schedules for the given class and section
    //     $examSchedules = ExamSchedule::where('class_id', $class_id)
    //         ->where('section_id', $section_id)
    //         ->with('subject', 'classes', 'sections')
    //         ->get();

    //     // dd($examSchedules);

    //     // Prepare data for the view
    //     $data = [
    //         'student' => $student,
    //         'class' => $class,
    //         'section' => $section,
    //         'marksheet' => $marksheet,
    //         'examSchedules' => $examSchedules,
    //     ];

    //     // Return the view with the prepared data
    //     return view('backend.school_admin.mark_sheet_design.marksheetdesign', $data);
    // }



    // public function downloadMarkSheet($student_id, $class_id, $section_id, $marksheetdesign_id)
    // {
    //     $student = Student::with('user')->findOrFail($student_id);
    //     $class = Classg::findOrFail($class_id);
    //     $section = Section::findOrFail($section_id);
    //     $marksheet = MarkSheetDesign::findOrFail($marksheetdesign_id);

    //     // Fetch exam schedules for the given class and section
    //     $examSchedules = ExamSchedule::where('class_id', $class_id)
    //         ->where('section_id', $section_id)
    //         ->with('subject', 'classes', 'sections')
    //         ->get();

    //     // Prepare data for the view
    //     $data = [
    //         'student' => $student,
    //         'class' => $class,
    //         'section' => $section,
    //         'marksheet' => $marksheet,
    //         'examSchedules' => $examSchedules,
    //     ];

    //     // Generate HTML for the mark sheet
    //     $html = view('backend.school_admin.mark_sheet_design.marksheetdesign', $data)->render();

    //     // Initialize Dompdf options
    //     $options = new \Dompdf\Options();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $dompdf = new \Dompdf\Dompdf($options);
    //     $dompdf->loadHtml($html);

    //     // Render PDF
    //     $dompdf->render();

    //     // Set the file name
    //     $fileName = 'mark_sheet_' . $student_id . '.pdf';

    //     // Get PDF content
    //     $pdfContent = $dompdf->output();

    //     // Return the response for downloading
    //     return response()->streamDownload(function () use ($pdfContent) {
    //         echo $pdfContent;
    //     }, $fileName, [
    //         'Content-Type' => 'application/pdf',
    //     ]);
    // }




    public function downloadMarkSheet($classId, $sectionId, $marksheetId)
    {
        $class = Classg::findOfFail($classId);
        $section = Section::findOrFail($sectionId);
        $marksheet = MarkSheetDesign::findOrFail($marksheetId);

        $html = view('backend.school_admin.mark_sheet_design.marksheetdesign', compact('class', 'section', 'marksheet'))->render();
    }




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
        $schoolId = session('school_id');

        $dataTableQuery = Examination::where('school_id', $schoolId)
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->get();

        return $dataTableQuery;
    }


    public function getAllStudents(Request $request)
    {
        if ($request->has('class_id') && $request->has('section_id')) {
            $classId = $request->input('class_id');
            $sectionId = $request->input('section_id');

            $students = $this->studentUserService->getStudentsForDataTable($request->all())
                ->where('class_id', $classId)
                ->where('section_id', $sectionId);


            if ($students instanceof \Illuminate\Database\Query\Builder) {
                // Fetch the data from the query
                $students = $students->get();
            } else {
            }
            // dd($students);

            return Datatables::of($students)
                ->escapeColumns([])


                ->editColumn('f_name', function ($row) {
                    return $row->f_name;
                })

                ->editColumn('l_name', function ($row) {
                    return $row->l_name;
                })
                ->editColumn('roll_no', function ($row) {
                    return $row->roll_no;
                })
                ->editColumn('father_name', function ($row) {
                    return $row->father_name;
                })
                ->editColumn('mother_name', function ($row) {
                    return $row->mother_name;
                })
                ->editColumn('guardian_is', function ($row) {
                    return $row->guardian_is;
                })

                ->addColumn('created_at', function ($user) {
                    return $user->created_at->diffForHumans();
                })
                ->addColumn('status', function ($student) {
                    return $student->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
                })

                ->make(true);

            return Datatables::of([])
                ->escapeColumns([])
                ->make(true);
        }
    }


    // public function generateMarkSheetPDF(Request $request)
    // {
    //     $data = [
    //         [
    //             'quantity' => 1,
    //             'description' => '1 Year Subscription',
    //             'price' => '129.00'
    //         ]
    //     ];

    //     // $pdf = Pdf::loadView('pdf', ['data' => $data]);
    //     $pdf = Pdf::loadView('backend.school_admin.mark_sheet_design.marksheetdesign', ['data' => $data]);

    //     return $pdf->download();


    //     // instantiate and use the dompdf class
    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml('hello world');

    //     // (Optional) Setup the paper size and orientation
    //     $dompdf->setPaper('A4', 'landscape');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Output the generated PDF to Browser
    //     $dompdf->download();
    //     $designId = $request->input('design_id');
    //     $studentId = $request->input('student_id');

    //     // Retrieve the mark sheet design based on the ID
    //     $design = MarkSheetDesign::findOrFail($designId);

    //     // Retrieve student information based on the ID
    //     $student = Student::findOrFail($studentId);

    //     // Load the mark sheet template view with the design and student data
    //     $html = view('backend.school_admin.mark_sheet_design.marksheetdesign', compact('design', 'student'))->render();

    //     // Configure Dompdf options
    //     $options = new Options();
    //     $options->set('isHtml5ParserEnabled', true);

    //     // Instantiate Dompdf
    //     $dompdf = new Dompdf($options);
    //     // dd($dompdf);
    //     // Load HTML content
    //     $dompdf->loadHtml($html);

    //     // Set paper size and orientation (optional)
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();
    //     $dompdf->stream();
    //     dd($dompdf);

    //     // Get the generated PDF content
    //     $pdfContent = $dompdf->output();
    //     // dd($pdfContent);
    //     // Set the appropriate headers for downloading the file
    //     return response()->streamDownload(
    //         function () use ($pdfContent) {
    //             echo $pdfContent;
    //         },
    //         'mark_sheet.pdf'
    //     );
    // }
}