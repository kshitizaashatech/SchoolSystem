<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $page_title = 'Leave Type Listing';
        $leaveTypes = LeaveType::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.leave_type.index', compact('page_title', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'type' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $leaveTypeData = $request->all();
            $savedData = LeaveType::create($leaveTypeData);

            return redirect()->back()->withToastSuccess('Leave Type Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $leaveType = LeaveType::find($id);
        return view('backend.shared.leave_type.index', compact('leaveType'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'type' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $leaveType = LeaveType::findOrFail($id);

        try {
            $data = $request->all();
            $updateNow = $leaveType->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Leave Type!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Leave Type. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $leaveType = LeaveType::find($id);

        try {
            $updateNow = $leaveType->delete();
            return redirect()->back()->withToastSuccess('Leave Type has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllLeaveTypes(Request $request)
    {
        $leaveTypes = $this->getForDataTable($request->all());

        return Datatables::of($leaveTypes)
            ->escapeColumns([])

            ->addColumn('type', function ($leaveType) {
                return $leaveType->type;
            })
            ->addColumn('created_at', function ($leaveType) {
                return $leaveType->created_at->diffForHumans();
            })
            ->addColumn('status', function ($attendanceType) {
                return $attendanceType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($leaveType) {
                return view('backend.shared.leave_type.partials.controller_action', ['leaveType' => $leaveType])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = LeaveType::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}