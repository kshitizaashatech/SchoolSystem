<?php

namespace App\Http\Services;

use App, Auth;
use Carbon\Carbon;
use App\Models\School;
use App\Models\StudentSession;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

class DashboardService
{
    // /**
    //  * @var User
    //  */
    // protected $user;

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