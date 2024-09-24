<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Models\Classg;
use App\Models\Student;
use App\Models\Examination;
use Illuminate\Http\Request;
use App\Models\AdmitCardDesign;
use App\Models\MarkSheetDesign;
use App\Http\Services\FormService;
use App\Http\Controllers\Controller;
use App\Http\Services\StudentUserService;
use Yajra\Datatables\Datatables;
use ZipArchive;

class GenerateAdmitCardController extends Controller
{
    protected $formService;
    protected $studentUserService;

    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }
    protected $imageSavePath = '/uploads/students/admit_card/';

    public function index()
    {
        $page_title = "Print Admit Card";
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $admitcard_designs = AdmitCardDesign::all();
        $examination = Examination::all();
        return view('backend.school_admin.generate_admit_card.index', compact('page_title', 'classes', 'admitcard_designs', 'examination'));
    }

    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        return response()->json($sections);
    }

    public function showAdmitCardDesign($student_id, $admit_card_id, $examination_id)
    {
        // Retrieve student, admit card, examination, and exam schedules
        $student = Student::with('user')->findOrFail($student_id);
        $admitCard = AdmitCardDesign::findOrFail($admit_card_id);
        $examination = Examination::findOrFail($examination_id);
        $examSchedule = Examination::findOrFail($examination_id)->examSchedules;
        // dd($examSchedule);

        // Generate base64 encoded images for right and left logos
        $base64EncodedImageRight = $this->generateBase64EncodedImage($admitCard->right_logo);
        $base64EncodedImageLeft = $this->generateBase64EncodedImage($admitCard->left_logo);
        $base64EncodedBackgroundImage = $this->generateBase64EncodedImage($admitCard->background_img);

        // Check if all required data is available
        if ($student && $admitCard && $examination && $examSchedule->isNotEmpty()) {
            // Prepare data for the view
            $data = [
                'student' => $student,
                'admitCard' => $admitCard,
                'examination' => $examination,
                'examSchedule' => $examSchedule,
                'base64EncodedImageRight' => $base64EncodedImageRight,
                'base64EncodedImageLeft' => $base64EncodedImageLeft,
                'base64EncodedBackgroundImage' => $base64EncodedBackgroundImage,
                'isPdfDownload' => false
            ];

            // Return the view with the prepared data
            return view('backend.school_admin.admit_card_design.ajax_admitcard', $data);
        }

        return response()->json(['message' => 'Missing parameters'], 400);
    }


    public function printAdmitCard()
    {
        $page_title = "Print Admit Card";
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $admitcard_designs = AdmitCardDesign::all();
        $examination = Examination::all();
        return view('backend.school_admin.admit_card_design.print_admitcard', compact('page_title', 'classes', 'admitcard_designs', 'examination'));
    }
    public function downloadAdmitCard($student_id, $admit_card_id, $examination_id)
    {

        $student = Student::with('user')->findOrFail($student_id);
        $admitCard = AdmitCardDesign::findOrFail($admit_card_id);
        $examination = Examination::findOrFail($examination_id);
        $examSchedule = Examination::findOrFail($examination_id)->examSchedules;

        // Generate base64 encoded images for right and left logos
        $base64EncodedImageRight = $this->generateBase64EncodedImage($admitCard->right_logo);
        $base64EncodedImageLeft = $this->generateBase64EncodedImage($admitCard->left_logo);
        $base64EncodedBackgroundImage = $this->generateBase64EncodedImage($admitCard->background_img);



        $html = view('backend.school_admin.admit_card_design.ajax_admitcard', [
            'student' => $student,
            'admitCard' => $admitCard,
            'examination' => $examination,
            'examSchedule' => $examSchedule,
            'base64EncodedImageRight' => $base64EncodedImageRight,
            'base64EncodedImageLeft' => $base64EncodedImageLeft,
            'base64EncodedBackgroundImage' => $base64EncodedBackgroundImage,
            'isPdfDownload' => true
        ]); // Pass a flag to indicate PDF download

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->render();
        $fileName = 'admit_card_' . $student_id . '.pdf';
        $pdfContent = $dompdf->output();

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }


    // Helper function to generate base64 encoded image
    private function generateBase64EncodedImage($filename)
    {
        $filePath = public_path('uploads/students/admit_card/' . $filename);
        if (file_exists($filePath)) {
            return base64_encode(file_get_contents($filePath));
        }
        return null;
    }


    public function getAllStudents(Request $request)
    {
        $admit_card_id = $request->input('admit_card_id');
        if ($request->has('class_id') && $request->has('section_id')) {
            $classId = $request->input('class_id');
            $sectionId = $request->input('section_id');
            $examination_id = $request->input('examination_id');
            $students = $this->studentUserService->getStudentsForDataTable($request->all())
                ->where('class_id', $classId)
                ->where('section_id', $sectionId);



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
                ->addColumn('actions', function ($student) use ($admit_card_id, $examination_id) {
                    return view('backend.school_admin.generate_admit_card.partials.controller_action', ['student' => $student, 'admit_card_id' => $admit_card_id, 'examination_id' => $examination_id])->render();
                })



                ->make(true);

            return Datatables::of([])
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function getAllAdmitCardDesign(Request $request)
    {
        $admit_card_design = $this->getForDataTable($request->all());
        // dd($user);
        return Datatables::of($admit_card_design)
            ->editColumn('heading', function ($row) {
                return $row->heading;
            })
            ->editColumn('title', function ($row) {
                return $row->title;
            })

            ->editColumn('exam_name', function ($row) {
                return $row->exam_name;
            })
            ->editColumn('school_name', function ($row) {
                return $row->school_name;
            })
            ->editColumn('exam_center', function ($row) {
                return $row->exam_center;
            })

            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })

            ->addColumn('status', function ($admit_card_design) {
                return $admit_card_design->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($admit_card_design) {
                return view('backend.school_admin.admit_card_design.partials.controller_action', [
                    'admit_card_design' => $admit_card_design
                ])->render();
            })

            ->make(true);
    }
    public function getForDataTable($request)
    {
        $dataTableQuery = AdmitCardDesign::where(function ($query) use ($request) {
            if (isset ($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

    public function bulkDownloadAdmitCards(Request $request)
    {
        $studentIds = $request->input('student_ids');
        $admitCardId = $request->input('admit_card_id');
        $examinationId = $request->input('examination_id');
    
        $zipFileName = 'bulk_admit_cards.zip';
        $zip = new ZipArchive;
    
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            foreach ($studentIds as $studentId) {
                $pdfContent = $this->generateAdmitCardPDF($studentId, $admitCardId, $examinationId);
                $zip->addFromString("admit_card_student_{$studentId}.pdf", $pdfContent);
            }
            $zip->close();
        }
    
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }
    
    private function generateAdmitCardPDF($student_id, $admit_card_id, $examination_id)
    {
        $student = Student::with('user')->findOrFail($student_id);
        $admitCard = AdmitCardDesign::findOrFail($admit_card_id);
        $examination = Examination::findOrFail($examination_id);
        $examSchedule = Examination::findOrFail($examination_id)->examSchedules;
    
        $base64EncodedImageRight = $this->generateBase64EncodedImage($admitCard->right_logo);
        $base64EncodedImageLeft = $this->generateBase64EncodedImage($admitCard->left_logo);
        $base64EncodedBackgroundImage = $this->generateBase64EncodedImage($admitCard->background_img);
    
        $html = view('backend.school_admin.admit_card_design.ajax_admitcard', [
            'student' => $student,
            'admitCard' => $admitCard,
            'examination' => $examination,
            'examSchedule' => $examSchedule,
            'base64EncodedImageRight' => $base64EncodedImageRight,
            'base64EncodedImageLeft' => $base64EncodedImageLeft,
            'base64EncodedBackgroundImage' => $base64EncodedBackgroundImage,
            'isPdfDownload' => true
        ])->render();
    
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
    
        $dompdf->render();
        return $dompdf->output();
    }
}