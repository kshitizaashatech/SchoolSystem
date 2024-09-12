<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SchoolService;

class SchoolWiseReportController extends Controller
{
    protected $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function getSchoolWiseReportCollection(Request $request)
    {
        $date = $request->input('date');
        $schools_wise_reports = $this->schoolService->schoolWiseReportDetails($date);
        return response()->json($schools_wise_reports); 
    } }
