<?php

namespace App\Http\Controllers\SchoolHead;

use DB, Auth;
use App\Models\Unit;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;

use App\Http\Services\SchoolService;
use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $schoolService;

    public function __construct(DashboardService $dashboardService, SchoolService $schoolService)
    {
        $this->dashboardService = $dashboardService;
        $this->schoolService = $schoolService;
    }

    public function index()
    {
        $page_title = Auth::user()->getRoleNames()[0] . ' ' . "Dashboard";
        //school students
        $school_students = $this->schoolService->getSchoolStudent();
        $school_students_count = $this->schoolWiseCountOfStudent($school_students);
        //school staffs
        $school_staffs = $this->schoolService->getSchoolStaff();
        $school_staffs_count = $this->schoolWiseCountOfStaff($school_staffs);


        //school staffs
        $school_wise_student_attendences = $this->schoolService->getSchoolWiseStudentAttendence();
        // $school_staffs_count = $this->schoolWiseCountOfStaff($school_staffs);
        // dd($school_wise_student_attendences);


        return view('backend.municipality_admin.dashboard.dashboard', compact('page_title', 'school_students_count', 'school_staffs_count', 'school_wise_student_attendences'));
    }

    public function schoolWiseCountOfStudent($originalData)
    {
        // Initialize labels and data arrays
        $labels = [];
        $data = [];

        // Iterate over the original data array
        foreach ($originalData as $item) {
            $labels[] = $item['name'];
            $data[] = $item['total_student'];
        }

        // Construct the required data structure
        $finalData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'School wise Student Count',
                    'data' => $data,
                    'borderWidth' => 1
                ]
            ]
        ];
        return $finalData;
    }
    public function schoolWiseCountOfStaff($originalData)
    {
        // Initialize labels and data arrays
        $labels = [];
        $data = [];

        // Iterate over the original data array
        foreach ($originalData as $item) {
            $labels[] = $item['name'];
            $data[] = $item['total_staffs'];
        }

        // Construct the required data structure
        $finalData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'School wise Staffs Count',
                    'data' => $data,
                    'borderWidth' => 1
                ]
            ]
        ];
        return $finalData;
    }


}