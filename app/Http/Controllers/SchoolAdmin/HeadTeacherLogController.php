<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;
use App\Models\HeadTeacherLog;
use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class HeadTeacherLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "List Head Teacher Logs";

        return view('backend.school_admin.logs.head_teacher_logs.index', compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'major_incidents' => 'nullable|string',
            'major_work_observation' => 'nullable|string',
            'assembly_management' => 'nullable|string',
            'miscellaneous' => 'nullable|string', 
            'logged_date' => 'nullable|string',
        ]);
    
        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }
    
        try {
            $headTeacherLog = $request->all();
            $headTeacherLog['school_id'] = session('school_id'); // Assign the current school ID
            $headTeacherLog['head_teacher_id'] = Auth::id();
            $savedData = HeadTeacherLog::create($headTeacherLog);
            return redirect()->back()->withToastSuccess('Head Teacher Log Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validatedData = Validator::make($request->all(), [
        'major_incidents' => 'nullable|string',
        'major_work_observation' => 'nullable|string',
        'assembly_management' => 'nullable|string',
        'miscellaneous' => 'nullable|string', 
        'logged_date' => 'nullable|string',
    ]);

    if ($validatedData->fails()) {
        return back()->withToastError($validatedData->messages()->all()[0])->withInput();
    }

    $headTeacherLog = HeadTeacherLog::findOrFail($id);

    try {
        $data = $request->all();
        $data['school_id'] = session('school_id');
        $data['head_teacher_id'] = Auth::id();
        $updateNow = $headTeacherLog->update($data);

        return redirect()->back()->withToastSuccess('Successfully Updated Head Teacher Log!');
    } catch (\Exception $e) {
        return back()->withToastError($e->getMessage())->withInput();
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $headTeacherLog = HeadTeacherLog::findOrFail($id);

        try {
            $updateNow = $headTeacherLog->delete();
            return redirect()->back()->withToastSuccess('Head Teacher Log has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllHeadTeacherLogs(Request $request)
    {
        $headTeacherLog = $this->getForDataTable($request->all());

        return Datatables::of($headTeacherLog)
            ->escapeColumns([])
            ->addColumn('major_incidents', function ($log) {
                return $log->major_incidents;
            })
            ->addColumn('major_work_observation', function ($log) {
                return $log->major_work_observation;
            })
            ->addColumn('assembly_management', function ($log) {
                return $log->assembly_management;
            })
            ->addColumn('miscellaneous', function ($log) {
                return $log->miscellaneous;
            })
            ->addColumn('logged_date', function ($log) {
                return $log->logged_date;
            })

            ->addColumn('actions', function ($log) {
                return view('backend.school_admin.logs.head_teacher_logs.partials.controller_action', ['log' => $log])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $schoolId = session('school_id'); // Get the current school ID from the session
    
        $dataTableQuery = HeadTeacherLog::where('school_id', $schoolId) // Filter by school ID
            ->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', $request['id']);
                }
            })
            ->get();
    
        return $dataTableQuery;
    }
}