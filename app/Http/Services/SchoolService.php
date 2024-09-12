<?php

namespace App\Http\Services;

use App, Auth;
use Carbon\Carbon;
use App\Models\School;
use App\Models\StudentSession;
use App\Models\HeadTeacherLog;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

class SchoolService
{
    // /**
    //  * @var User
    //  */
    // protected $user;

    //retrieves school details based on various criteria, which can include district ID, municipality ID, or wada ID.
   
    public static function getSchoolDetailsByCriteria($stateId = null, $districtId = null, $municipalityId = null, $wadaId = null, $school_type = null, $schoolId = null)
    {
        $query = School::query();

        if ($stateId) {
            $query->where('state_id', $stateId);
        }
        if ($districtId) {
            $query->where('district_id', $districtId);
        }
        if ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        }
        if ($wadaId) {
            $query->where('ward_id', $wadaId);
        }
        if ($school_type) {
            $query->where('school_type', $school_type);
        }
        if ($schoolId) {
            $query->where('id', $schoolId);
        }

        return $query->get();
    }

    public static function getSchoolStudent($districtId = null, $municipalityId = null, $classId = null, $sectionId = null, $userCount = null, $rows = false)
    {
        $query = School::withCount('studentSessions as total_student');

        if ($districtId) {
            $query->where('district_id', $districtId);
        }

        if ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        }
        $query->whereHas('studentSessions', function ($query) use ($classId, $sectionId) {
            $query->where('academic_session_id', session('academic_session_id'));
            if ($classId) {
                $query->where('class_id', $classId);
            }
            if ($sectionId) {
                $query->where('section_id', $sectionId);
            }
        });

        return $query->get();


    }
    public static function getSchoolStaff($schoolId = null, $districtId = null, $municipalityId = null, $userCount = null, $rows = false)
    {
        $query = School::withCount('staffs as total_staffs');

        if ($districtId) {
            $query->where('district_id', $districtId);
        }

        if ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        }
        if ($schoolId) {
            $query->where('id', $schoolId);
        }

        return $query->get();


    }

    public function schoolWiseReportDetails($date = null)
    {

        $municipalityId = Auth::user()->municipality_id;

        //get all schools details associated to municipality
        // $schools = $this->schoolService->getSchoolDetailsByCriteria(null, null, Auth::user()->municipality_id);

        $schools = $this->getSchoolDetailsByCriteria(null, null, $municipalityId);
        $reportDetails = [];
        foreach ($schools as $school) {
            $students = $this->getSchoolWiseStudentAttendence($school->id, $date);
            $staffs = $this->getSchoolWiseStaffAttendence($school->id, $date);
            $head_teacher_logs = $this->getSchoolWiseHeadTeacherLogsDetails($school->id, $date);

            $reportDetails[] = [
                'school_name' => $students[0]['school_name'],
                'total_student' => $students[0]['total_student'],
                'present_student' => $students[0]['present_student'],
                'absent_student' => $students[0]['absent_student'],
                'late_student' => $students[0]['late_student'],
                'total_staffs' => $staffs[0]['total_staffs'],
                'present_staffs' => $staffs[0]['present_staffs'],
                'absent_staffs' => $staffs[0]['absent_staffs'],
                'late_staffs' => $staffs[0]['late_staffs'],
                'holiday_staffs' => $staffs[0]['holiday_staffs'],

                'major_incidents' => $head_teacher_logs->major_incidents ?? '',
                'eca_cca' => ($head_teacher_logs->major_work_observation ?? '') . ' / ' . ($head_teacher_logs->assembly_management ?? ''),
                'miscellaneous' => $head_teacher_logs->miscellaneous ?? '',
            ];
        }
        
        return $reportDetails;
    }

    public function InventoryReportDetails($school_id, $date = null)
{
    $SchoolId = Auth::user()->municipality_id;

    //get all schools details associated to municipality
    // $schools = $this->schoolService->getSchoolDetailsByCriteria(null, null, Auth::user()->municipality_id);

    $schools = $this->getSchoolDetailsByCriteria(null, null, $SchoolId);
   

}

public function IncomeReportDetails($school_id, $date = null)
{
    $SchoolId = Auth::user()->municipality_id;

    //get all schools details associated to municipality
    // $schools = $this->schoolService->getSchoolDetailsByCriteria(null, null, Auth::user()->municipality_id);

    $schools = $this->getSchoolDetailsByCriteria(null, null, $SchoolId);
   

}

// public function ExamDetails($school_id, $date = null)
// {
//     $AcdemicSessionId = Auth::user()->municipality_id;

//     //get all session details associated to school
//     // $schools = $this->schoolService->getSchoolDetailsByCriteria(null, null, Auth::user()->municipality_id);

//     $sessions = $this->getSchoolDetailsByCriteria(null, null, $AcdemicSessionId);
   

// }

public function ExpensesReportDetails($school_id, $date = null)
{
    $SchoolId = Auth::user()->municipality_id;

    //get all schools details associated to municipality
    // $schools = $this->schoolService->getSchoolDetailsByCriteria(null, null, Auth::user()->municipality_id);

    $schools = $this->getSchoolDetailsByCriteria(null, null, $SchoolId);
   

}



    public static function getSchoolWiseHeadTeacherLogsDetails($schoolId = null, $date = null, $districtId = null, $municipalityId = null, $classId = null, $sectionId = null, $userCount = null, $rows = false)
    {
        if (!$date) {
            // $date = Carbon::now()->toDateString();
            $date = LaravelNepaliDate::from(Carbon::now())->toNepaliDate();
        }
        $query = HeadTeacherLog::whereDate('logged_date', $date);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }
        return $query->latest('created_at')->first();

    }
    
    public static function getSchoolWiseStudentAttendence($schoolId = null, $date = null, $districtId = null, $municipalityId = null, $classId = null, $sectionId = null, $userCount = null, $rows = false)
    {
        if (!$date) {
            // $date = Carbon::now()->toDateString();
            $date = LaravelNepaliDate::from(Carbon::now())->toNepaliDate();
        }
    
        $schools = School::query()
            ->withCount([
                'studentSessions as total_student',
                'studentSessions as present_student' => function ($query) use ($date) {
                    $query->whereHas('studentAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 1) // present
                            ->whereDate('date', $date);
                    });
                },
                'studentSessions as absent_student' => function ($query) use ($date) {
                    $query->whereHas('studentAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 2) // absent
                            ->whereDate('date', $date);
                    });
                },
                'studentSessions as late_student' => function ($query) use ($date) {
                    $query->whereHas('studentAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 3) // late
                            ->whereDate('date', $date);
                    });
                }
            ]);
    
        if ($schoolId) {
            $schools->where('id', $schoolId);
        }
    
        $results = $schools->get(['id', 'name', 'total_student', 'present_student', 'absent_student', 'late_student']);
    
        // Format the data as required
        $formattedData = [];
        foreach ($results as $school) {
            $formattedData[] = [
                'school_name' => $school->name,
                'total_student' => $school->total_student,
                'present_student' => $school->present_student,
                'absent_student' => $school->absent_student,
                'late_student' => $school->late_student,
            ];
        }
    
        return $formattedData;
    }
    
    public static function getSchoolWiseStaffAttendence($schoolId = null, $date = null, $districtId = null, $municipalityId = null, $classId = null, $sectionId = null, $userCount = null, $rows = false)
    {
        if (!$date) {
            // $date = Carbon::now()->toDateString();
            $date = LaravelNepaliDate::from(Carbon::now())->toNepaliDate();
        }
    
        $schools = School::query()
            ->withCount([
                'staffs as total_staffs',
                'staffs as present_staffs' => function ($query) use ($date) {
                    $query->whereHas('staffsAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 1) // present
                            ->whereDate('date', $date);
                    });
                },
                'staffs as absent_staffs' => function ($query) use ($date) {
                    $query->whereHas('staffsAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 2) // absent
                            ->whereDate('date', $date);
                    });
                },
                'staffs as late_staffs' => function ($query) use ($date) {
                    $query->whereHas('staffsAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 3) // late
                            ->whereDate('date', $date);
                    });
                },
                'staffs as holiday_staffs' => function ($query) use ($date) {
                    $query->whereHas('staffsAttendances', function ($subQuery) use ($date) {
                        $subQuery->where('attendance_type_id', 4) // holiday
                            ->whereDate('date', $date);
                    });
                }
            ]);
    
        if ($schoolId) {
            $schools->where('id', $schoolId);
        }
    
        $results = $schools->get(['id', 'total_staffs', 'present_staffs', 'absent_staffs', 'late_staffs', 'holiday_staffs']);
    
        // Format the data as required
        $formattedData = [];
        foreach ($results as $school) {
            $formattedData[] = [
                'school_name' => $school->name,
                'total_staffs' => $school->total_staffs,
                'present_staffs' => $school->present_staffs,
                'absent_staffs' => $school->absent_staffs,
                'late_staffs' => $school->late_staffs,
                'holiday_staffs' => $school->holiday_staffs,
            ];
        }
    
        return $formattedData;
    }
    
    public static function getClassWiseStudents($schoolId = null, $date = null, $districtId = null, $municipalityId = null, $classId = null, $sectionId = null, $userCount = null, $rows = false)
    {
        // Get all students grouped by school and class
        $students = StudentSession::select('school_id', 'class_id', StudentSession::raw('count(user_id) as total_students'))
            ->groupBy('school_id', 'class_id')
            ->get();

        // Initialize an empty array to store formatted data
        $formattedData = [];

        // Loop through the result to format the data
        foreach ($students as $student) {
            $schoolName = School::findOrFail($student->school_id)->name;
            $class = 'total_student_class_' . $student->class_id;

            // Check if the school data exists in the formatted array
            if (!isset($formattedData[$schoolName])) {
                $formattedData[$schoolName] = [
                    'school_name' => $schoolName
                ];
            }

            // Assign the total students to the respective class key
            $formattedData[$schoolName][$class] = $student->total_students;
        }

        // Convert the formatted data to a simple array
        return array_values($formattedData);

        // Now $formattedData contains the desired formatted data
        // dd($formattedData);

    }

}