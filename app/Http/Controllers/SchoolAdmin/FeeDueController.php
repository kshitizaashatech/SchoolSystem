<?php

namespace App\Http\Controllers\SchoolAdmin;

use DB;
use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Classg;
use App\Models\FeeDue;
use App\Models\Section;
use App\Models\Student;
use App\Models\FeeGroup;
use Illuminate\Http\Request;
use App\Models\StudentSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeeDueController extends Controller
{
    public function index()
    {
        $page_title = 'Fee Due Listing';

        $feegroup = FeeGroup::orderBy('created_at', 'desc')->paginate(10);
        $classmanagement = Classg::orderBy('created_at', 'desc')->paginate(10);
        $section = Section::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.fee_due.index', compact('page_title', 'feegroup', 'classmanagement', 'section'));
    }
    public function getAllSearchData(Request $request)
    {
        $classId = $request->input('classId');
        $sectionId = $request->input('sectionId');
        $feeGroupsID = $request->input('feeGroupsID');
        // Retrieve academic session ID and school ID from the session
        $academicSessionId = session('academic_session_id');
        $schoolId = session('school_id');
        // dd($academicSessionId);

        $students = User::join('students', 'users.id', '=', 'students.user_id')
            ->join('student_sessions', 'students.user_id', '=', 'student_sessions.user_id')
            ->leftJoin(
                DB::raw('(SELECT student_id, SUM(amount) as total_paid
                     FROM fee_collections
                     GROUP BY student_id) as paid_fees'),
                'students.id',
                '=',
                'paid_fees.student_id'
            )
            ->leftJoin(
                DB::raw('(
                SELECT fc.student_id, SUM(fgt.amount) as total_fee
                FROM (
                    SELECT DISTINCT student_id, fee_groups_types_id
                    FROM fee_collections
                ) as fc
                INNER JOIN fee_groups_types as fgt ON fc.fee_groups_types_id = fgt.id
                GROUP BY fc.student_id
            ) as total_fees'),
                'students.id',
                '=',
                'total_fees.student_id'
            )
            ->leftJoin('classes', 'student_sessions.class_id', '=', 'classes.id')
            ->leftJoin('sections', 'student_sessions.section_id', '=', 'sections.id')
            ->leftJoin('fee_collections', 'students.id', '=', 'fee_collections.student_id')
            ->leftJoin('fee_groups_types', 'fee_collections.fee_groups_types_id', '=', 'fee_groups_types.id')
            ->leftJoin('fee_groups', 'fee_groups_types.fee_group_id', '=', 'fee_groups.id')
            ->leftJoin('academic_sessions', 'student_sessions.academic_session_id', '=', 'academic_sessions.id')
            ->where('users.user_type_id', '=', 8)
            // ->where('student_sessions.academic_session_id', '=', $academicSessionId)
            // ->where('student_sessions.school_id', '=', $schoolId)
            ->where(function ($query) use ($classId, $sectionId) {
                $query->where('student_sessions.class_id', $classId)
                    ->where('student_sessions.section_id', $sectionId);
            })
            ->orWhere(function ($query) use ($classId, $sectionId) {
                $query->where('academic_sessions.to_date', '>=', now())
                    ->where('student_sessions.class_id', $classId)
                    ->where('student_sessions.section_id', $sectionId);
            })
            ->when($feeGroupsID, function ($query) use ($feeGroupsID) {
                $query->whereIn('fee_groups.id', $feeGroupsID);
            })
            ->groupBy('students.id')
            ->select(
                'students.id as student_id',
                DB::raw('MAX(users.f_name) as f_name'),
                DB::raw('MAX(users.l_name) as l_name'),
                DB::raw('MAX(students.admission_no) as admission_no'),
                DB::raw('MAX(classes.class) as class_name'),
                DB::raw('MAX(sections.section_name) as section_name'),
                DB::raw('GROUP_CONCAT(DISTINCT fee_groups.name) as fee_groups'),
                DB::raw('COALESCE(MAX(total_fees.total_fee), 0) as total_fee'),
                DB::raw('COALESCE(MAX(paid_fees.total_paid), 0) as total_paid'),
                DB::raw('COALESCE(MAX(total_fees.total_fee), 0) - COALESCE(MAX(paid_fees.total_paid), 0) as fee_due_amount')
            )
            ->get();
        // dd($students);
        return $students;
    }
}
