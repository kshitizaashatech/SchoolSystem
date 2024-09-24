<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AttendanceType;
use App\Models\StudentSession;
use Yajra\Datatables\Datatables;
use App\Models\StudentAttendance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Services\StudentUserService;
use App\Http\Services\FormService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;


class StudentAttendanceController extends Controller
{
    // protected $formService;
    // protected $studentUserService;

    // public function __construct(FormService $formService, StudentUserService $studentUserService)
    // {
    //     $this->formService = $formService;
    //     $this->studentUserService = $studentUserService;
    // }
    public function index()
    {
        $page_title = 'Student Attendance Listing';
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $attendance_types = AttendanceType::all();

        return view('backend.school_admin.student_attendance.index', compact('page_title', 'classes', 'attendance_types'));
    }

    // public function saveAttendance(Request $request)
    // {
    //     try {
    //         // Retrieve data from the request
    //         $attendanceData = $request->input('attendance_data');

    //         // Process and save the attendance data
    //         foreach ($attendanceData as $data) {
    //             $studentId = $data['student_id'];
    //             $attendanceType = $data['attendance_type_id'];
    //             $date = $data['date'];
    //             $remarks = $data['remarks'];

    //             // Get the user ID associated with the student
    //             $userId = Student::find($studentId)->user_id;

    //             // Get the student session ID
    //             $studentSessionId = $this->getStudentSessionId($userId, $date);

    //             if ($studentSessionId) {
    //                 // If student session ID exists, update the record
    //                 $attendance = new StudentAttendance();
    //                 $attendance->attendance_type_id = $attendanceType;
    //                 $attendance->student_session_id = $studentSessionId;
    //                 $attendance->date = $date;
    //                 $attendance->remarks = $remarks;
    //                 $attendance->save();
    //             } else {
    //                 // If no student session ID is found, handle accordingly
    //                 return response()->json(['message' => 'No active student session found for the given user and date.'], 404);
    //             }
    //         }

    //         // Return a success response
    //         return response()->json(['message' => 'Attendance saved successfully']);
    //     } catch (\Exception $e) {
    //         // Return an error response if something goes wrong
    //         return response()->json(['message' => 'Error saving attendance', 'error' => $e->getMessage()], 500);
    //     }
    // }

    public function saveAttendance(Request $request)
    {
        try {
            // Retrieve data from the request
            $attendanceData = $request->input('attendance_data');

            // Process and save the attendance data
            foreach ($attendanceData as $data) {
                $studentId = $data['student_id'];
                $attendanceType = $data['attendance_type_id'];
                $date = $data['date'];
                $remarks = $data['remarks'];

                // Get the user ID associated with the student
                $userId = Student::find($studentId)->user_id;

                // Get the student session ID
                $studentSessionId = $this->getStudentSessionId($userId, $date);

                // Check if the student session ID exists
                if ($studentSessionId) {
                    // Try to find an existing record for the given date and student session ID
                    $existingAttendance = StudentAttendance::where('date', $date)
                        ->where('student_session_id', $studentSessionId)
                        ->first();

                    if ($existingAttendance) {
                        // If an existing record is found, update it
                        $existingAttendance->attendance_type_id = $attendanceType;
                        $existingAttendance->remarks = $remarks;
                        $existingAttendance->save();
                    } else {
                        // If no existing record is found, create a new one
                        $newAttendance = new StudentAttendance();
                        $newAttendance->attendance_type_id = $attendanceType;
                        $newAttendance->student_session_id = $studentSessionId;
                        $newAttendance->date = $date;
                        $newAttendance->remarks = $remarks;
                        $newAttendance->save();
                    }
                } else {
                    // If no student session ID is found, handle accordingly
                    return response()->json(['message' => 'No active student session found for the given user and date.'], 404);
                }
            }

            // Return a success response
            // return response()->json(['message' => 'Attendance saved successfully']);
            return back()->withToastSuccess('Attendance saved successfully');
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            // return response()->json(['message' => 'Error saving attendance', 'error' => $e->getMessage()], 500);
            return back()->withToastError('Error saving attendance: ' . $e->getMessage());
        }
    }

    private function getStudentSessionId($userId, $date)
    {
        // Query the StudentSession model to find a session for a specific user and date
        $session = StudentSession::where('user_id', $userId)
            ->where('school_id', session('school_id'))
            ->where('is_active', 1)
            ->first();

        // If a session is found, return its ID; otherwise, return null
        return $session ? $session->id : null;
    }



    // private function getStudentSessionId($userId, $date)
    // {
    //     // Query the StudentSession model to find a session for a specific user and date
    //     $session = StudentSession::where('user_id', $userId)
    //         ->where('school_id', session('school_id'))
    //         ->whereHas('studentAttendances', function ($attendanceQuery) use ($date) {
    //             $attendanceQuery->where('date', $date);
    //         })
    //         ->first();

    //     // If a session is found, return its ID; otherwise, create a new session
    //     if ($session) {
    //         return $session->id;
    //     }
    // }

    // public function saveAttendance(Request $request)
    // {
    //     // dd($request->all());
    //     try {
    //         // Retrieve data from the request
    //         $classId = $request->input('class_id');
    //         $sectionId = $request->input('section_id');
    //         $date = $request->input('attendance_data.0.date');
    //         $attendanceData = $request->input('attendance_data');
    //         // dd($attendanceData);

    //         // Process and save the attendance data
    //         foreach ($attendanceData as $studentId => $data) {
    //             $attendanceType = $data['attendance_type_id'];
    //             $remarks = $data['remarks'];

    //             $student = Student::find($studentId);

    //             dd($student->toArray());
    //             $session = $student->session()->latest()->first();

    //             dd($session->id);

    //             // Assuming you have a StudentAttendance model
    //             $attendance = new StudentAttendance();
    //             $attendance->attendance_type_id = $attendanceType;
    //             $attendance->student_session_id = $session->id;;
    //             $attendance->date = $date;
    //             $attendance->remarks = $remarks;
    //             $attendance->save();
    //         }

    //         // Return a success response
    //         return response()->json(['message' => 'Attendance saved successfully']);
    //     } catch (\Exception $e) {
    //         // Return an error response if something goes wrong
    //         return response()->json(['message' => 'Error saving attendance', 'error' => $e->getMessage()], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'attendance_type_id' => 'required|integer',
            'date' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $studentAttendanceData = $request->all();

            $studentAttendanceData['student_session_id'] = 1;

            $savedData = StudentAttendance::create($studentAttendanceData);

            return redirect()->back()->withToastSuccess('attendance Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function show()
    {
    }

    public function edit(string $id)
    {
        $studentAttendance = StudentAttendance::find($id);
        return view('backend.school_admin.student_attendance.index', compact('attendanceType'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'biometric_attendance' => 'required|integer',
            // 'attendance_type_id' => 'required|integer',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $studentAttendance = StudentAttendance::findOrFail($id);

        try {
            $data = $request->all();
            $data['attendance_type_id'] = 1;
            $data['student_session_id'] = 1;
            $data['school_id'] = 1;
            $data['staff_id '] = 1;
            $updateNow = $studentAttendance->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated attendance!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update attendance. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $studentAttendance = StudentAttendance::find($id);

        try {
            $updateNow = $studentAttendance->delete();
            return redirect()->back()->withToastSuccess('attendance  has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllStudentAttendance(Request $request)
    {
        // Use getForDataTable to handle data fetching and sorting
        $students = $this->getForDataTable($request->all());
    
        return Datatables::of($students)
            ->addColumn('admission_no', function ($query) {
                return $query->student->admission_no;
            })
            ->addColumn('roll_no', function ($query) {
                return $query->student->roll_no;
            })
            ->addColumn('f_name', function ($query) {
                return $query->student->user->f_name;
            })
            ->addColumn('attendance_type_id', function ($query) {
                return $query->attendanceType->type;
            })
            ->addColumn('remarks', function ($query) {
                return $query->remarks;
            })
            ->addColumn('created_at', function ($query) {
                return $query->created_at->diffForHumans();
            })
            ->addColumn('status', function ($query) {
                return $query->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($query) {
                return view('backend.school_admin.student_attendance.partials.controller_action', ['studentAttendance' => $query])->render();
            })
            ->rawColumns(['status', 'actions']) // Ensure columns with HTML are rendered correctly
            ->make(true);
    }
    
    public function getForDataTable($request)
    {
        $query = StudentAttendance::with(['student', 'student.user', 'attendanceType'])
            ->join('students', 'student_attendances.student_id', '=', 'students.id'); 
    
        // Apply filters
        if (isset($request['class_id']) && $request['class_id'] !== '') {
            $query->where('students.class_id', $request['class_id']);
        }
        if (isset($request['section_id']) && $request['section_id'] !== '') {
            $query->where('students.section_id', $request['section_id']);
        }
        if (isset($request['date']) && $request['date'] !== '') {
            $query->whereDate('student_attendances.date', $request['date']);
        }
    
        // Handle sorting based on roll number
        if (isset($request['order'][0]['column'])) {
            $column = $request['columns'][$request['order'][0]['column']]['data']; // Use 'data' instead of 'name'
            $direction = $request['order'][0]['dir'];
    
            // Always prioritize sorting by roll number
            if ($column === 'roll_no') {
                $query->orderBy('students.roll_no', $direction);
            } else {
                // Fallback sorting for other columns if needed
                switch ($column) {
                    case 'admission_no':
                        $query->orderBy('students.admission_no', $direction);
                        break;
                    case 'f_name':
                        $query->join('users', 'students.user_id', '=', 'users.id')
                              ->orderBy('users.f_name', $direction);
                        break;
                    default:
                        $query->orderBy($column, $direction);
                }
            }
        } else {
            // Default sorting by roll number if no sorting is provided
            $query->orderBy('students.roll_no', 'asc');
        }
    
        return $query->get();
    }
    

    public function markSchoolHoliday(Request $request)
    {
        try {
            $schoolId = session('school_id');
            $date = Carbon::parse($request->input('date', now()));
    
            DB::beginTransaction();
    
            // Update existing attendance records to holiday for all students in the school
            $updatedCount = StudentAttendance::whereHas('studentSession', function ($query) use ($schoolId) {
                $query->whereHas('student', function ($query) use ($schoolId) {
                    $query->where('school_id', $schoolId);
                });
            })->where('date', $date->toDateString())
              ->update(['attendance_type_id' => 4, 'remarks' => 'Holiday']);
    
            // Insert new attendance records for students without existing records for the date
            $students = Student::where('school_id', $schoolId)->get();
    
            foreach ($students as $student) {
                // Get student sessions for the school and student
                $studentSessions = $student->studentSessions()
                    ->where('school_id', $schoolId)
                    ->pluck('id');
    
                foreach ($studentSessions as $studentSessionId) {
                    // Check if attendance record already exists for the student session and date
                    $existingAttendance = StudentAttendance::where('student_session_id', $studentSessionId)
                        ->where('date', $date->toDateString())
                        ->first();
    
                    if (!$existingAttendance) {
                        // Create a new attendance record
                        $newAttendance = new StudentAttendance();
                        $newAttendance->student_session_id = $studentSessionId;
                        $newAttendance->date = $date->toDateString();
                        $newAttendance->attendance_type_id = 4; // Set to 4 for holiday
                        $newAttendance->remarks = 'Holiday'; // Optional: Add remarks if needed
    
                        $newAttendance->save();
                    }
                }
            }
    
            DB::commit();
    
            return response()->json(['success' => true, 'message' => "Student attendances updated/inserted successfully for holiday."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update/insert student attendances for holiday: ' . $e->getMessage()]);
        }
    }

    public function markHolidayRange(Request $request)
    {
   
    try {
        $schoolId = session('school_id');
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $reason = $request->input('reason');
    
        DB::beginTransaction();
    
        // Iterate through each date in the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Update existing attendance records to holiday for all students in the school
            $updatedCount = StudentAttendance::whereHas('studentSession', function ($query) use ($schoolId) {
                $query->whereHas('student', function ($query) use ($schoolId) {
                    $query->where('school_id', $schoolId);
                });
            })->where('date', $date->toDateString())
              ->update(['attendance_type_id' => 4, 'remarks' => $reason]);
    
            // Insert new attendance records for students without existing records for the date
            $students = Student::where('school_id', $schoolId)->get();
    
            foreach ($students as $student) {
                // Get student sessions for the school and student
                $studentSessions = $student->studentSessions()
                    ->where('school_id', $schoolId)
                    ->pluck('id');
    
                foreach ($studentSessions as $studentSessionId) {
                    // Check if attendance record already exists for the student session and date
                    $existingAttendance = StudentAttendance::where('student_session_id', $studentSessionId)
                        ->where('date', $date->toDateString())
                        ->first();
    
                    if (!$existingAttendance) {
                        // Create a new attendance record
                        $newAttendance = new StudentAttendance();
                        $newAttendance->student_session_id = $studentSessionId;
                        $newAttendance->date = $date->toDateString();
                        $newAttendance->attendance_type_id = 4; // Set to 4 for holiday
                        $newAttendance->remarks = $reason; // Optional: Add remarks if needed
    
                        $newAttendance->save();
                    }
                }
            }
        }
    
        DB::commit();
    
        return response()->json(['success' => true, 'message' => "Student attendances updated/inserted successfully for holiday range."]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Failed to update/insert student attendances for holiday range: ' . $e->getMessage()]);
    }
}
}