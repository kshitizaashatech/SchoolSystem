<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Models\Classg;
use Illuminate\Http\Request;
use App\Models\StudentSession;
use App\Http\Services\FormService;
use App\Models\PrimaryExamination;
use App\Http\Controllers\Controller;
use App\Models\PrimaryExamStudent;

class PrimaryExaminationStudentsController extends Controller
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function assignPrimaryStudents(string $id)
    {
        $examinations = PrimaryExamination::find($id);
        $page_title = "Assign Primary Students To " . $examinations->exam;
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.primary_examination.student.create', compact('page_title', 'classes', 'examinations'));
    }

    public function getExamAssignPrimaryStudents($id, $classId, $sectionId)
    {
        $students = $this->formService->getExamAssignStudents($id, $classId, $sectionId);
        return response()->json($students);
    }


    public function saveAssignPrimaryStudentsToExam(Request $request)
    {
        try {
            // Delete records that are not present in the updated input data
            $studentSessionsToDelete = $this->studentSessionsToDelete($request);
            //store the records
            foreach ($request->input('student_sessions') as $studentSessionId) {
                $studentSession = [
                    'student_session_id' => $studentSessionId,
                    'examination_id' => $request->input('examination_id'),
                    'is_active' => 1
                ];

                // Update the record if it exists, otherwise create a new one
                PrimaryExamStudent::updateOrCreate(
                    ['student_session_id' => $studentSessionId],
                    $studentSession
                );
            }

            return back()->withToastSuccess('Assigned successfully');
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return back()->withToastError('Error assigning exam: ' . $e->getMessage());
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
