<?php

namespace App\Http\Controllers\SchoolAdmin;

use Carbon\Carbon;
use App\Models\Classg;
use App\Models\School;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentSession;
use App\Models\ExamResult;
use App\Models\MarksGrade;
use App\Models\Examination;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MarkSheetDesign;
use Yajra\Datatables\Datatables;
use App\Http\Services\PdfService;
use App\Http\Services\FormService;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Services\ExamResultService;
use App\Http\Services\StudentUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateMarkSheetController extends Controller
{

    protected $pdfService;
    protected $formService;
    protected $studentUserService;
    protected $examResultService;

    public function __construct(FormService $formService, StudentUserService $studentUserService, ExamResultService $examResultService, PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
        $this->examResultService = $examResultService;
    }

    public function index()
    {
        $page_title = 'Generate Marksheet';
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $marksheet_designs = MarkSheetDesign::all();
        $examination = Examination::all();
        
        return view('backend.school_admin.generate_mark_sheet.index', compact('page_title', 'classes', 'schoolId', 'marksheet_designs', 'examination'));
    }

    public function create()
    {
    }

    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        return response()->json($sections);
    }

    public function getAllStudent(Request $request)
    {
        // dd($request->all());
        // dd("HELLO");
        $marksheetdesign_id = $request->input('marksheet_design_id');
        if ($request->has('class_id') && $request->has('section_id')) {
            $classId = $request->input('class_id');
            $sectionId = $request->input('section_id');
            $examination_id = $request->input('examination_id');
            $students = $this->studentUserService->getStudentsForDataTable($request->all())
                ->where('class_id', $classId)
                ->where('section_id', $sectionId);

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
                ->addColumn('actions', function ($student) use ($marksheetdesign_id, $examination_id) {
                    return view('backend.school_admin.generate_mark_sheet.partials.controller_action', ['student' => $student, 'marksheet_design_id' => $marksheetdesign_id, 'examination_id' => $examination_id])->render();
                })
                // ->addColumn('actions', function ($student) use ($marksheetdesign_id) {
                //     return view('backend.school_admin.generate_mark_sheet.partials.controller_action', ['student' => $student, 'marksheet_design_id' => $marksheetdesign_id])->render();
                // })

                ->make(true);

            return Datatables::of([])
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function getAllMarksheets($examination_id)
    {
        $page_title = 'Print Marksheet';
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $marksheet_designs = MarkSheetDesign::all();
        $examination_id = Examination::findOrFail($examination_id);

        return view('backend.school_admin.examination.print_marksheet', compact('page_title', 'classes', 'marksheet_designs', 'examination_id'));
    }

    // public function generateExamResult($examinations)
    // {
    //     return $this->examResultService->getStudentResultsBySubject($examinations);
    // }

    // SHOW FUNCTION
    public function showMarkSheetDesign($student_id, $class_id, $section_id, $marksheetdesign_id, $examination_id)
    {
        $school = School::findOrFail(session('school_id'));
        $logoFilename = $school->logo;
        $marksheet = MarkSheetDesign::findOrFail($marksheetdesign_id);
        $examinations = Examination::findOrFail($examination_id);
        $studentSession = StudentSession::with('user')->findOrFail($student_id);
        $student = $studentSession->user;
        $studentDetails = Student::where('user_id', $studentSession->user_id)->firstOrFail();
    
        if ($examinations->exam_type == 'terminal') {
            $data = $this->processTerminalExam($studentSession, $examinations);
        } else {
            $data = $this->processFinalExam($studentSession, $examinations);
        }
    
        $data = array_merge($data, [
            'marksheet' => $marksheet,
            'student' => $student,
            'studentDetails' => $studentDetails,
            'examinations' => $examinations,
            'school' => $school,
            'logoFilename' => $logoFilename,
            'markgrades' => MarksGrade::all(),
            'today' => Carbon::today(),
        ]);
    
        if ($examinations->exam_type == "terminal") {
            return view('backend.school_admin.mark_sheet_design.marksheetdesignterminal', $data);
        } else {
            return view('backend.school_admin.mark_sheet_design.marksheetdesignfinal', $data);
        }
    }

    public function generateExamResult($student_id, $examinations)
    {
        return $this->examResultService->getStudentResultsBySubject($examinations, $student_id);
    }
    public function generateBase64EncodedImage($filename)
    {
        $filePath = public_path('uploads/' . $filename);
        
        if (!file_exists($filePath)) {
            error_log("File not found: $filePath");
            return null;
        }
        
        if (!is_readable($filePath)) {
            error_log("File not readable: $filePath");
            return null;
        }
        
        $content = @file_get_contents($filePath);
        
        if ($content === false) {
            error_log("Failed to read file: $filePath");
            return null;
        }
        
        return base64_encode($content);
    }
    


    private function getGradePointFromMarks($totalMarks)
    {
        $gradeInfo = MarksGrade::where('percentage_from', '<=', $totalMarks)
            ->where('percentage_to', '>=', $totalMarks)
            ->first();

        return $gradeInfo ? $gradeInfo->grade_points_to : 0;
    }

    private function calculateGPA($processedResults)
    {
        $totalCreditHours = 0;
        $totalWeightedGradePoints = 0;
        
        foreach ($processedResults as $result) {
            $creditHours = $result['credit_hour'] ?? 1;
            $creditHours = is_numeric($creditHours) ? (float)$creditHours : 1;
            
            $gradePoint = $result['grade_point'] ?? 0;
            
            $totalCreditHours += $creditHours;
            $totalWeightedGradePoints += $gradePoint * $creditHours;
        }
        
        return $totalCreditHours > 0 ? round($totalWeightedGradePoints / $totalCreditHours, 2) : 0;
    }
    
private function getGradeInfo($totalMarks, $allZero = false)
{
    if ($allZero) {
        return [
            'grade_points_to' => 0,
            'grade_name' => 'NG',
            'achievement_description' => 'Not Attempted',
        ];
    }
    $gradePoint = $this->getSubjectGPA($totalMarks);

    $gradeName = 'NG'; 
    $achievementDescription = 'Not Graded'; 

    if ($totalMarks > 45) {
        $gradeName = 'A';
        $achievementDescription = 'Excellent';
    } elseif ($totalMarks > 40) {
        $gradeName = 'B';
        $achievementDescription = 'Very Good';
    } elseif ($totalMarks > 35) {
        $gradeName = 'C';
        $achievementDescription = 'Good';
    } elseif ($totalMarks > 30) {
        $gradeName = 'D';
        $achievementDescription = 'Satisfactory';
    } elseif ($totalMarks > 25) {
        $gradeName = 'E';
        $achievementDescription = 'Pass';
    } elseif ($totalMarks > 20) {
        $gradeName = 'F';
        $achievementDescription = 'Below Average';
    } elseif ($totalMarks > 18) {
        $gradeName = 'G';
        $achievementDescription = 'Poor';
    }

    return [
        'grade_points_to' => $gradePoint,
        'grade_name' => $gradeName,
        'achievement_description' => $achievementDescription,
    ];
}

    public function downloadStudentMarkSheet($student_id, $class_id, $section_id, $marksheetdesign_id, $examination_id)
    {
        try {
            $school = School::findOrFail(session('school_id'));
            $marksheet = MarkSheetDesign::findOrFail($marksheetdesign_id);
            $examinations = Examination::findOrFail($examination_id);
            $studentSession = StudentSession::with('user')->findOrFail($student_id);
            $student = $studentSession->user;
            $studentDetails = Student::where('user_id', $studentSession->user_id)->firstOrFail();

            if ($examinations->exam_type == 'terminal') {
                $data = $this->processTerminalExam($studentSession, $examinations);
            } else {
                $data = $this->processFinalExam($studentSession, $examinations);
            }

            $data = array_merge($data, [
                'marksheet' => $marksheet,
                'student' => $student,
                'studentDetails' => $studentDetails,
                'examinations' => $examinations,
                'school' => $school,
                'markgrades' => MarksGrade::all(),
                'today' => Carbon::today(),
            ]);

            Log::info('Marksheet Data: ', $data);

            $view = $examinations->exam_type == 'terminal' 
                ? 'backend.school_admin.mark_sheet_design.downloadmarksheetterminal'
                : 'backend.school_admin.mark_sheet_design.downloadmarksheetfinal';

            Log::info('Generating PDF with view: ' . $view);

            $html = view($view, $data)->render();

            $pdf = Browsershot::html($html)->pdf();

            Log::info('PDF Generated Successfully.');

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="marksheet_' . $student_id . '.pdf"');

        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to generate PDF: ' . $e->getMessage()], 500);
        }
    }

    private function processTerminalExam($studentSession, $examination)
    {
        $examResults = ExamResult::where('student_session_id', $studentSession->id)
            ->whereHas('examSchedule', function ($query) use ($examination) {
                $query->where('examination_id', $examination->id);
            })
            ->with(['studentSession.classg', 'studentSession.section', 'examStudent', 'examSchedule', 'subject'])
            ->get();
    
        $processedResults = $examResults->map(function ($result) {
            $participantAssessment = $result->participant_assessment ?? 0;
            $practicalAssessment = $result->practical_assessment ?? 0;
            $theoryAssessment = $result->theory_assessment ?? 0;
    
            // Convert theory assessment to 10-point scale
            $convertedTheoryAssessment = ($theoryAssessment / 50) * 10;
    
            $totalMarks = $participantAssessment + $practicalAssessment + $convertedTheoryAssessment;
            $allZero = ($participantAssessment == 0 && $practicalAssessment == 0 && $theoryAssessment == 0);
            $gradeInfo = $this->getGradeInfo($totalMarks, $allZero);
            $subjectGPA = $allZero ? 0 : $this->getSubjectGPA($totalMarks);
    
            return [
                'subject_id' => $result->subject->id ?? $result->subject_id,
                'subject_name' => $result->subject->subject ?? 'Unknown Subject',
                'credit_hour' => $result->subject->credit_hour ?? 'Unknown Credit Hour',
                'participant_assessment' => $participantAssessment,
                'practical_assessment' => $practicalAssessment,
                'theory_assessment' => $theoryAssessment,
                'converted_theory' => $convertedTheoryAssessment,
                'total' => $totalMarks,
                'grade' => $gradeInfo,
                'grade_point' => $subjectGPA,
                'course_type' => 'theory',
            ];
        });
    
        $gpa = $this->calculateGPA($processedResults);
    
        return [
            'examResults' => $processedResults,
            'gpa' => $gpa,
            'className' => $examResults->first()->studentSession->classg->class ?? 'Unknown Class',
            'sectionName' => $examResults->first()->studentSession->section->section_name ?? 'Unknown Section',
            'subjectNames' => $processedResults->pluck('subject_name')->unique()->toArray(),
        ];
    }
    
    public function processFinalExam($studentSession, $examination)
    {
        $allExamResults = ExamResult::where('student_session_id', $studentSession->id)
            ->whereHas('examSchedule.examination', function ($query) use ($examination) {
                $query->where('exam_type', 'terminal')
                      ->orWhere('id', $examination->id);
            })
            ->with([
                'studentSession.classg', 
                'studentSession.section', 
                'examStudent', 
                'examSchedule.examination', 
                'subject' 
            ])
            ->get();

        $subjectByRoutine = $examination->subjectByRoutine;
    
        $restructuredResults = [];
        $firstTermResults = [];
        $secondTermResults = [];

        foreach ($allExamResults as $result) {
            $subjectId = $result->subject_id;
            $examType = $result->examSchedule->examination->exam_type;
    
            if ($examType === 'terminal') {
                if (!isset($firstTermResults[$studentSession->id][$subjectId])) {
                    $firstTermResults[$studentSession->id][$subjectId] = $result;
                } else {
                    $secondTermResults[$studentSession->id][$subjectId] = $result;
                }
            } else {
                $restructuredResults[$studentSession->id][$subjectId] = $result;
            }
        }
    
        $processedResults = [];
        $totalCreditHours = 0;
        $totalGradePoints = 0;
    
        foreach ($subjectByRoutine as $subject) {
            $result = $restructuredResults[$studentSession->id][$subject->id] ?? null;
            $firstTermResult = $firstTermResults[$studentSession->id][$subject->id] ?? null;
            $secondTermResult = $secondTermResults[$studentSession->id][$subject->id] ?? null;

            $creditHours = $result->subject->credit_hour ?? 1;


    
            if ($result) {
                $firstTermTotal = $firstTermResult ? $firstTermResult->theory_assessment * 0.05 : 0;
                $secondTermTotal = $secondTermResult ? $secondTermResult->theory_assessment * 0.05 : 0;
    
                $internalMarks = $firstTermTotal + $secondTermTotal +
                                 $result->participant_assessment +
                                 $result->practical_assessment;
    
                $theoryMarks = $result->theory_assessment * 0.5;
                $totalMarks = $internalMarks + $theoryMarks;
    
                $allZero = ($result->participant_assessment == 0 &&
                            $result->practical_assessment == 0 &&
                            $result->theory_assessment == 0 &&
                            $firstTermTotal == 0 && $secondTermTotal == 0);
    
                $gradeInfo = $this->getGradeInfoFinal($totalMarks, $allZero);
                $gpa = $allZero ? 0 : $this->calculateGPAFinal($totalMarks);
    
                $totalCreditHours += $creditHours;
                $totalGradePoints += $gpa * $creditHours;
    
                $processedResults[$subject->id] = [
                    'subject_name' => $result->subject->subject ?? 'Unknown Subject',
                    'credit_hour' => $creditHours,
                    'internal_marks' => number_format($internalMarks, 2),
                    'theory_marks' => number_format($theoryMarks, 2),
                    'total_marks' => number_format($totalMarks, 2),
                    'gpa' => number_format($gpa, 2),
                    'grade' => $gradeInfo,
                    'all_zero' => $allZero,
                ];
            } else {
                $processedResults[$subject->id] = [
                    'subject_name' => $subject->subject ?? 'Unknown Subject',
                    'credit_hour' => $creditHours,
                    'internal_marks' => 'N/A',
                    'theory_marks' => 'N/A',
                    'total_marks' => 'N/A',
                    'gpa' => 'N/A',
                    'grade' => ['grade_name' => 'NG', 'achievement_description' => 'Not Graded'],
                    'all_zero' => true,
                ];
            }
        }

        $overallGPA = $totalCreditHours ? number_format($totalGradePoints / $totalCreditHours, 2) : 0;
    
        return [
            'examResults' => $processedResults,
            'overallGPA' => $overallGPA,
            'className' => $allExamResults->first()->studentSession->classg->class ?? 'Unknown Class',
            'sectionName' => $allExamResults->first()->studentSession->section->section_name ?? 'Unknown Section',
        ];
    }
    
    
    private function calculateGPAFinal($totalMarks)
    {
        if ($totalMarks > 90) return 4.0;
        elseif ($totalMarks > 80) return 3.6;
        elseif ($totalMarks > 70) return 3.2;
        elseif ($totalMarks > 60) return 2.8;
        elseif ($totalMarks > 50) return 2.4;
        elseif ($totalMarks > 40) return 2.0;
        elseif ($totalMarks > 32) return 1.6;
        else return 0.0;
    }

    private function getGradeInfoFinal($totalMarks, $allZero = false)
    {
        if ($allZero) {
            return [
                'grade_name' => 'NG',
                'achievement_description' => 'Not Attempted',
            ];
        }

        if ($totalMarks > 90) {
            return ['grade_name' => 'A+', 'achievement_description' => 'Outstanding'];
        } elseif ($totalMarks > 80) {
            return ['grade_name' => 'A', 'achievement_description' => 'Excellent'];
        } elseif ($totalMarks > 70) {
            return ['grade_name' => 'B+', 'achievement_description' => 'Very Good'];
        } elseif ($totalMarks > 60) {
            return ['grade_name' => 'B', 'achievement_description' => 'Good'];
        } elseif ($totalMarks > 50) {
            return ['grade_name' => 'C+', 'achievement_description' => 'Satisfactory'];
        } elseif ($totalMarks > 40) {
            return ['grade_name' => 'C', 'achievement_description' => 'Acceptable'];
        } elseif ($totalMarks > 32) {
            return ['grade_name' => 'D', 'achievement_description' => 'Partially Acceptable'];
        } else {
            return ['grade_name' => 'NG', 'achievement_description' => 'Not Graded'];
        }
    }

private function getSubjectGPA($totalMarks)
{
    if ($totalMarks > 45) {
        $gpa = 4.0;
    } elseif ($totalMarks > 40) {
        $gpa = 3.6;
    } elseif ($totalMarks > 35) {
        $gpa = 3.2;
    } elseif ($totalMarks > 30) {
        $gpa = 2.8;
    } elseif ($totalMarks > 25) {
        $gpa = 2.4;
    } elseif ($totalMarks > 20) {
        $gpa = 2.0;
    } elseif ($totalMarks > 18) {
        $gpa = 1.6;
    } else {
        $gpa = 0.0;
    }

    return $gpa;
}

private function getSubjectGPAFinal($totalMarks)
{
    if ($totalMarks > 90) return 4.0;
            elseif ($totalMarks > 80) return 3.6;
            elseif ($totalMarks > 70) return 3.2;
            elseif ($totalMarks > 60) return 2.8;
            elseif ($totalMarks > 50) return 2.4;
            elseif ($totalMarks > 40) return 2.0;
            elseif ($totalMarks > 32) return 1.6;
            else return 0.0;
}
public function bulkDownloadMarksheets(Request $request)
{
    $studentIds = explode(',', $request->input('student_ids'));
    $classId = $request->input('class_id');
    $sectionId = $request->input('section_id');
    $marksheetDesignId = $request->input('marksheet_design_id');
    $examinationId = $request->input('examination_id');

    $zip = new \ZipArchive();
    $zipFileName = 'marksheets.zip';
    $zipFilePath = storage_path('app/public/' . $zipFileName);

    if ($zip->open($zipFilePath, \ZipArchive::CREATE) !== TRUE) {
        return response()->json(['error' => 'Unable to create zip file'], 100);
    }

    foreach ($studentIds as $studentId) {
        try {
            $pdf = $this->generateStudentMarksheetPDF($studentId, $classId, $sectionId, $marksheetDesignId, $examinationId);
            $pdfFileName = 'marksheet_' . $studentId . '.pdf';
            $zip->addFromString($pdfFileName, $pdf);
        } catch (\Exception $e) {
            Log::error('Error generating PDF for student ' . $studentId . ': ' . $e->getMessage());
            continue;
        }
    }

    $zip->close();

    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}

private function generateStudentMarksheetPDF($studentId, $classId, $sectionId, $marksheetDesignId, $examinationId)
{
    $school = School::findOrFail(session('school_id'));
    $marksheet = MarkSheetDesign::findOrFail($marksheetDesignId);
    $examinations = Examination::findOrFail($examinationId);
    $studentSession = StudentSession::with('user')->findOrFail($studentId);
    $student = $studentSession->user;
    $studentDetails = Student::where('user_id', $studentSession->user_id)->firstOrFail();

    if ($examinations->exam_type == 'terminal') {
        $data = $this->processTerminalExam($studentSession, $examinations);
    } else {
        $data = $this->processFinalExam($studentSession, $examinations);
    }

    $data = array_merge($data, [
        'marksheet' => $marksheet,
        'student' => $student,
        'studentDetails' => $studentDetails,
        'examinations' => $examinations,
        'school' => $school,
        'markgrades' => MarksGrade::all(),
        'today' => Carbon::today(),
    ]);

    $view = $examinations->exam_type == 'terminal' 
        ? 'backend.school_admin.mark_sheet_design.downloadmarksheetterminal'
        : 'backend.school_admin.mark_sheet_design.downloadmarksheetfinal';

    $html = view($view, $data)->render();

    return Browsershot::html($html)->pdf();
}

}