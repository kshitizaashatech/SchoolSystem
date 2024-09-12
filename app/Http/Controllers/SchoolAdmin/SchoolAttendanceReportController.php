<?php

namespace App\Http\Controllers\SchoolAdmin;

use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Models\Classg;
use App\Models\ClassSection;
use App\Models\StudentSession;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Yajra\DataTables\DataTables;
use Carbon\CarbonPeriod;
use DB, Auth;

class SchoolAttendanceReportController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $classes = Classg::where('school_id', $schoolId)->get();
        return view('backend.school_admin.attendancereport.index', compact('classes'));
    }

    public function report(Request $request)
    {
        $inputFromDate = $request->input('from_date', Carbon::today()->format('Y-m-d'));
        $inputToDate = $request->input('to_date', Carbon::today()->format('Y-m-d'));
        $fromDate = LaravelNepaliDate::from($inputFromDate)->toEnglishDate();
        $toDate = LaravelNepaliDate::from($inputToDate)->toEnglishDate();
        $schoolId = Auth::user()->school_id;
        $classes = Classg::where('school_id', $schoolId)->get();

        // Generate date range
        $period = CarbonPeriod::create($fromDate, $toDate);
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return view('backend.school_admin.attendancereport.index', compact('classes', 'dates'));
    }

    public function getData(Request $request)
    {
        try {
            $fromDate = LaravelNepaliDate::from($request->input('from_date'))->toEnglishDate();
            $toDate = LaravelNepaliDate::from($request->input('to_date'))->toEnglishDate();
            $classId = $request->input('class_id');
            $studentName = $request->input('student_name');
    
            $period = CarbonPeriod::create($fromDate, $toDate);
            $dates = [];
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
    
            $query = StudentAttendance::with(['student.user', 'studentSession'])
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->when($classId, function ($query, $classId) {
                    return $query->whereHas('studentSession', function ($q) use ($classId) {
                        $q->where('class_id', $classId);
                    });
                })
                ->when($studentName, function ($query, $studentName) {
                    return $query->whereHas('student.user', function ($q) use ($studentName) {
                        $q->where('f_name', 'like', '%'.$studentName.'%')
                          ->orWhere('l_name', 'like', '%'.$studentName.'%');
                    });
                })
                ->get();
    
            $students = [];
            foreach ($query as $attendance) {
                $studentId = $attendance->student->id;
                if (!isset($students[$studentId])) {
                    $students[$studentId] = [
                        'student_name' => $attendance->student->user->f_name . ' ' . $attendance->student->user->l_name,
                        'attendance' => array_fill_keys($dates, null),
                    ];
                }
                $students[$studentId]['attendance'][Carbon::parse($attendance->created_at)->format('Y-m-d')] = $attendance->attendance_type;
            }
    
            $data = array_values($students);
    
            return DataTables::of($data)
                ->addColumn('student_name', function($row) {
                    return $row['student_name'];
                })
                ->addColumn('attendance', function($row) use ($dates) {
                    $attendance = [];
                    foreach ($dates as $date) {
                        $attendance[] = $row['attendance'][$date] ?? '-';
                    }
                    return implode(',', $attendance);
                })
                ->rawColumns(['attendance'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
     // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    //  public function getSections($classId)
    //  {
    //      $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
    //      return response()->json($sections);
    //  }
}
