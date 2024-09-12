<?php
namespace App\Http\Controllers\MunicipalityAdmin;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Yajra\DataTables\DataTables;

class AttendenceReportController extends Controller
{
    public function index()
    {
        $schools = School::all(); 
        return view('backend.municipality_admin.report.attendencereport.index', compact('schools'));
    }

    public function report(Request $request)
    {
        $inputDate = $request->input('date', Carbon::today()->format('Y-m-d')); // Default to today's date if not provided
        $date = LaravelNepaliDate::from($inputDate)->toEnglishDate();
        $schools = School::all(); // Fetch all schools
        $studentAttendances = StudentAttendance::whereDate('created_at', $date)->get();
        return view('backend.municipality_admin.report.attendencereport.index', compact('studentAttendances', 'date','schools'));
    }

    public function getData(Request $request)
    {
        $inputDate = $request->input('date', Carbon::today()->format('Y-m-d'));
        $schoolId=$request->input('school_id');// Default to today's date if not provided

        // if (!$inputDate || !$schoolId) {
        //     return response()->json(['data' => []]); // Return an empty dataset if date or school_id is not provided
        // }
        $date = LaravelNepaliDate::from($inputDate)->toEnglishDate();

       

        $query = StudentAttendance::with(['student.user', 'studentSession'])
        ->whereDate('created_at', $date)
        ->when($schoolId, function ($query, $schoolId) {
            // Join the student_sessions table and filter by school_id
            return $query->whereHas('studentSession', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        });

        return DataTables::of($query)
            ->addColumn('student_name', function ($attendance) {
                return $attendance->student->user->f_name . ' ' . $attendance->student->user->l_name;
            })
            ->addColumn('attendance_type', function ($attendance) {
                return $attendance->attendance_type_id == 1 ? 'Present' : 'Absent';
            })
            ->rawColumns(['student_name', 'attendance_type'])
            ->make(true); // Return the response as JSON
    }
}


