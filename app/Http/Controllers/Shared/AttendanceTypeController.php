<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\AttendanceType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;



class AttendanceTypeController extends Controller
{
    public function index()
    {
        $page_title = 'Attendance Type Listing';
        $attendanceTypes = AttendanceType::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.attendance_type.index', compact('page_title', 'attendanceTypes'));
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
            $attendanceTypeData = $request->all();
            $savedData = AttendanceType::create($attendanceTypeData);

            return redirect()->back()->withToastSuccess('attendance Type Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $attendanceType = AttendanceType::find($id);
        return view('backend.shared.attendance_type.index', compact('attendanceType'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'type' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $attendanceType = AttendanceType::findOrFail($id);

        try {
            $data = $request->all();
            $updateNow = $attendanceType->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated attendance Type!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update attendance Type. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $attendanceType = AttendanceType::find($id);

        try {
            $updateNow = $attendanceType->delete();
            return redirect()->back()->withToastSuccess('attendance Type has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllattendanceTypes(Request $request)
    {
        $attendanceTypes = $this->getForDataTable($request->all());

        return Datatables::of($attendanceTypes)
            ->escapeColumns([])

            ->addColumn('type', function ($attendanceType) {
                return $attendanceType->type;
            })
            ->addColumn('created_at', function ($feeType) {
                return $feeType->created_at->diffForHumans();
            })
            ->addColumn('status', function ($attendanceType) {
                return $attendanceType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($attendanceType) {
                return view('backend.shared.attendance_type.partials.controller_action', ['attendanceType' => $attendanceType])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = AttendanceType::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
