<?php
namespace App\Exports;

use App\Invoice;
use App\Models\Examination;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Services\ExamResultService;

class ExamResultExport implements FromView
{
    protected $examinations;

    public function __construct(Examination $examinations)
    {
        $this->examinations = $examinations;
    }

    public function view(): View
    {
        $examinations = $this->examinations;

        $examResultService = new ExamResultService(); // Or inject it via constructor if needed
        $studentSessions = $examResultService->getStudentResultsBySubject($this->examinations);

        if ($examinations->exam_type == "terminal") {
            return view('backend.school_admin.exam_result.resultexport', compact('examinations', 'studentSessions'));
        } else {
            return view('backend.school_admin.exam_result.finalresultexport', compact('examinations', 'studentSessions'));
        }

    }
}