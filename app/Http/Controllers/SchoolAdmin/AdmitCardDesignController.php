<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Models\Classg;
use App\Models\Student;
use App\Models\Examination;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\AdmitCardDesign;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\StudentUserService;
use App\Models\ExamSchedule;
use Dompdf\Dompdf;
use Dompdf\Options;

class AdmitCardDesignController extends Controller
{
    //
    protected $formService;
    protected $studentUserService;
    //
    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }
    protected $imageSavePath = '/uploads/students/admit_card/';

    public function index()
    {
        $page_title = "List Admit Card Design";

        return view('backend.school_admin.admit_card_design.index', compact('page_title'));
    }

    public function create()
    {
        $page_title = 'Create Admit Card Design';
        return view('backend.school_admin.admit_card_design.create', compact('page_title'));
    }


    // public function showAdmitCardDesign($student_id, $admit_card_id, $examination_id)
    // {
    //     // Retrieve student, admit card, examination, and exam schedules
    //     $student = Student::with('user')->findOrFail($student_id);
    //     $admitCard = AdmitCardDesign::findOrFail($admit_card_id);
    //     $examination = Examination::findOrFail($examination_id);
    //     $examSchedule = Examination::findOrFail($examination_id)->examSchedules;
    //     // dd($examSchedule);

    //     // Generate base64 encoded images for right and left logos
    //     $base64EncodedImageRight = $this->generateBase64EncodedImage($admitCard->right_logo);
    //     $base64EncodedImageLeft = $this->generateBase64EncodedImage($admitCard->left_logo);
    //     $base64EncodedBackgroundImage = $this->generateBase64EncodedImage($admitCard->background_img);

    //     // Check if all required data is available
    //     if ($student && $admitCard && $examination && $examSchedule->isNotEmpty()) {
    //         // Prepare data for the view
    //         $data = [
    //             'student' => $student,
    //             'admitCard' => $admitCard,
    //             'examination' => $examination,
    //             'examSchedule' => $examSchedule,
    //             'base64EncodedImageRight' => $base64EncodedImageRight,
    //             'base64EncodedImageLeft' => $base64EncodedImageLeft,
    //             'base64EncodedBackgroundImage' => $base64EncodedBackgroundImage,
    //             'isPdfDownload' => false
    //         ];

    //         // Return the view with the prepared data
    //         return view('backend.school_admin.admit_card_design.ajax_admitcard', $data);
    //     }

    //     return response()->json(['message' => 'Missing parameters'], 400);
    // }

    // // Helper function to generate base64 encoded image
    // private function generateBase64EncodedImage($filename)
    // {
    //     $filePath = public_path('uploads/students/admit_card/' . $filename);
    //     if (file_exists($filePath)) {
    //         return base64_encode(file_get_contents($filePath));
    //     }
    //     return null;
    // }


    public function store(Request $request)
    {
        $this->validate($request, [
            'template' => 'nullable',
            'heading' => 'nullable',
            'title' => 'nullable|string',
            // 'left_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'right_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'sign' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'background_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'is_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'exam_name' => 'nullable',
            'school_name' => 'nullable',
            'exam_center' => 'nullable',
            'exam_center' => 'nullable',
            'is_name' => 'boolean',
            'is_father_name' => 'boolean',
            'is_mother_name' => 'boolean',
            'is_dob' => 'boolean',
            'is_admission_no' => 'boolean',
            'is_roll_no' => 'boolean',
            'is_address' => 'boolean',
            'is_gender' => 'boolean',
            'is_class' => 'boolean',
            'is_session' => 'boolean',
            'content_footer' => 'nullable|string',
        ]);

        try {
            $input = $request->all();
            $input['school_id'] = 1;

            // for left_logo
            if ($request->hasFile('left_logo')) {
                $postPath = time() . '.' . $request->file('left_logo')->getClientOriginalExtension();
                $request->file('left_logo')->move(public_path('uploads/students/admit_card/'), $postPath);
                $input['left_logo'] = $postPath;
            } else {
                $input['left_logo'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['left_logo'] = $destinationPath;
            }
            // for right_logo

            if ($request->hasFile('right_logo')) {
                $postPath = time() . '.' . $request->file('right_logo')->getClientOriginalExtension();
                $request->file('right_logo')->move(public_path('uploads/students/admit_card/'), $postPath);
                $input['right_logo'] = $postPath;
            } else {
                $input['right_logo'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['right_logo'] = $destinationPath;
            }
            // for sign
            if ($request->hasFile('sign')) {
                $postPath = time() . '.' . $request->file('sign')->getClientOriginalExtension();
                $request->file('sign')->move(public_path('uploads/students/admit_card/'), $postPath);
                $input['sign'] = $postPath;
            } else {
                $input['sign'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['sign'] = $destinationPath;
            }
            // for background_img
            if ($request->hasFile('background_img')) {
                $postPath = time() . '.' . $request->file('background_img')->getClientOriginalExtension();
                $request->file('background_img')->move(public_path('uploads/students/admit_card/'), $postPath);
                $input['background_img'] = $postPath;
            } else {
                $input['background_img'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['background_img'] = $destinationPath;
            }

            $admit_card_design = AdmitCardDesign::create($input);
            if ($admit_card_design) {
                return redirect()->back()->withToastSuccess('Admit Card Design Successfully Created');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        try {
            $admin_card_design = AdmitCardDesign::findOrFail($id);
            $page_title = "Edit Admit Card Design";
            return view('backend.school_admin.admit_card_design.update', compact('admin_card_design', 'page_title'));
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'template' => 'nullable',
                'heading' => 'nullable',
                'title' => 'nullable|string',
                'left_logo' => 'nullable',
                'right_logo' => 'nullable',
                'sign' => 'nullable',
                'background_img' => 'nullable',
                'is_photo' => 'boolean',
                'exam_name' => 'nullable',
                'school_name' => 'nullable',
                'exam_center' => 'nullable',
                'exam_center' => 'nullable',
                'is_name' => 'boolean',
                'is_father_name' => 'boolean',
                'is_mother_name' => 'boolean',
                'is_dob' => 'boolean',
                'is_admission_no' => 'boolean',
                'is_roll_no' => 'boolean',
                'is_address' => 'boolean',
                'is_gender' => 'boolean',
                'is_class' => 'boolean',
                'is_session' => 'boolean',
                'content_footer' => 'nullable|string',
            ]);

            $input = $request->all();
            // dd($request->all());
            $input['school_id'] = 1;

            // Check if a new left_logo is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['left_logo'] = $destinationPath;
            } else {
                $input['left_logo'] = $request->input('old_left_logo');
            }

            unset($input['old_left_logo']);

            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['right_logo'] = $destinationPath;
            } else {

                $input['right_logo'] = $request->input('old_right_logo');
            }
            unset($input['old_right_logo']);

            // Check if a new sign is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['sign'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['sign'] = $request->input('old_sign');
            }
            unset($input['old_sign']);

            // Check if a new background_img is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['background_img'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['background_img'] = $request->input('old_background_img');
            }
            unset($input['old_background_img']);


            $admin_card_design = AdmitCardDesign::findOrFail($id);
            $admin_card_design->update($input);
            return redirect()->route('admin.admit-carddesigns.index')->withToastSuccess('Admin Card Design successfully Updated');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
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
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

    public function destroy($id)
    {
        try {
            $admit_card_design = AdmitCardDesign::findOrfail($id);
            $admit_card_design->delete();
            return redirect()->back()->withToastSuccess('Admit Card Design Successfully Deleted');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        return response()->json($sections);
    }

    // public function printAdmitCard()
    // {
    //     $page_title = "Print Admit Card";
    //     $schoolId = session('school_id');
    //     $classes = Classg::where('school_id', $schoolId)
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     $admitcard_designs = AdmitCardDesign::all();
    //     $examination = Examination::all();
    //     return view('backend.school_admin.admit_card_design.print_admitcard', compact('page_title', 'classes', 'admitcard_designs', 'examination'));
    // }
    // public function downloadAdmitCard($studentId, $admitCardId, $examinationId)
    // {

    //     $student = Student::with('user')->findOrFail($studentId);
    //     $admitCard = AdmitCardDesign::findOrFail($admitCardId);
    //     $examination = Examination::findOrFail($examinationId);
    //     $examSchedule = Examination::findOrFail($examinationId)->examSchedules;

    //     // Generate base64 encoded images for right and left logos
    //     $base64EncodedImageRight = $this->generateBase64EncodedImage($admitCard->right_logo);
    //     $base64EncodedImageLeft = $this->generateBase64EncodedImage($admitCard->left_logo);
    //     $base64EncodedBackgroundImage = $this->generateBase64EncodedImage($admitCard->background_img);



    //     $html = view('backend.school_admin.admit_card_design.ajax_admitcard', [
    //         'student' => $student,
    //         'admitCard' => $admitCard,
    //         'examination' => $examination,
    //         'examSchedule' => $examSchedule,
    //         'base64EncodedImageRight' => $base64EncodedImageRight,
    //         'base64EncodedImageLeft' => $base64EncodedImageLeft,
    //         'base64EncodedBackgroundImage' => $base64EncodedBackgroundImage,
    //         'isPdfDownload' => true
    //     ]); // Pass a flag to indicate PDF download

    //     $options = new \Dompdf\Options();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $dompdf = new \Dompdf\Dompdf($options);
    //     $dompdf->loadHtml($html);

    //     $dompdf->render();
    //     $fileName = 'admit_card_' . $studentId . '.pdf';
    //     $pdfContent = $dompdf->output();

    //     return response()->streamDownload(function () use ($pdfContent) {
    //         echo $pdfContent;
    //     }, $fileName, [
    //         'Content-Type' => 'application/pdf',
    //     ]);
    // }


    // public function getAllStudents(Request $request)
    // {
    //     if ($request->has('class_id') && $request->has('section_id')) {
    //         $classId = $request->input('class_id');
    //         $sectionId = $request->input('section_id');

    //         $students = $this->studentUserService->getStudentsForDataTable($request->all())
    //             ->where('class_id', $classId)
    //             ->where('section_id', $sectionId);


    //         if ($students instanceof \Illuminate\Database\Query\Builder) {
    //             // Fetch the data from the query
    //             $students = $students->get();
    //         } else {
    //         }
    //         // dd($students);

    //         return Datatables::of($students)
    //             ->escapeColumns([])


    //             ->editColumn('f_name', function ($row) {
    //                 return $row->f_name;
    //             })

    //             ->editColumn('l_name', function ($row) {
    //                 return $row->l_name;
    //             })
    //             ->editColumn('roll_no', function ($row) {
    //                 return $row->roll_no;
    //             })
    //             ->editColumn('father_name', function ($row) {
    //                 return $row->father_name;
    //             })
    //             ->editColumn('mother_name', function ($row) {
    //                 return $row->mother_name;
    //             })
    //             ->editColumn('guardian_is', function ($row) {
    //                 return $row->guardian_is;
    //             })

    //             ->addColumn('created_at', function ($user) {
    //                 return $user->created_at->diffForHumans();
    //             })
    //             ->addColumn('status', function ($student) {
    //                 return $student->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
    //             })



    //             ->make(true);

    //         return Datatables::of([])
    //             ->escapeColumns([])
    //             ->make(true);
    //     }
    // }
}
