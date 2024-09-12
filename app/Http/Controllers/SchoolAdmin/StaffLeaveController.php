<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use App\Models\LeaveType;
use App\Models\Staff;
use App\Models\StaffLeave;
use Validator;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentLeave;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StaffLeaveController extends Controller
{
    public function index()
    {
        $page_title = 'Staff Leave Listing';
        $leave_type = LeaveType::orderBy('created_at', 'desc')
            ->get();
        $staffs = Staff::where('school_id', session('school_id'))->orderBy('created_at', 'desc')
            ->get();
        return view('backend.school_admin.staff_leave.index', compact('page_title', 'leave_type', 'staffs'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'leave_type_id' => 'required|string',
            'staff_id' => 'required',
            'from_date' => 'required|date',
            'status' => 'required',
            'to_date' => 'required|date',
            'docs' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $staffsLeaveData = $request->all();
            $staffsLeaveData['school_id'] = session('school_id');
            if ($request->status == 1) {
                $staffsLeaveData['approved_by'] = auth()->user()->id;
                $staffsLeaveData['approved_date'] = Carbon::now();
            } elseif ($request->status == 0) {
                $staffsLeaveData['rejected_by'] = auth()->user()->id;
            }

            $staffsLeaveData['leave_days'] = $this->LeaveDaysCount($request);

            if ($request->hasFile('docs')) {
                $file = $request->file('docs');
                $subdirectory = 'uploads/leave_docs';
                $filename = $file->getClientOriginalName();
                $file->move(public_path($subdirectory), $filename);
                $staffsLeaveData['docs'] = $subdirectory . '/' . $filename;
            }
            // dd($staffsLeaveData);

            $savedData = StaffLeave::create($staffsLeaveData);

            return redirect()->back()->withToastSuccess('Staff Leave Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function LeaveDaysCount($request)
    {
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);

        return $toDate->diffInDays($fromDate);
    }

    public function edit($id)
    {
        // $staffLeave = StudentLeave::find($id);
        // return view('backend.school_admin.staff_leave.index', compact('leaveType'));
        $staffLeave = StudentLeave::findOrFail($id);
        $classmanagement = Classg::all();
        $sectionmanagement = Section::all();
        $studentmanagement = Student::all();

        return view('backend.school_admin.staff_leave.index', compact('staffLeave', 'classmanagement', 'sectionmanagement', 'studentmanagement'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'leave_type_id' => 'required|string',
            'staff_id' => 'required',
            'to_date' => 'required|date',
            'status' => 'required',
            'docs' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $staffLeave = StaffLeave::findOrFail($id);

        try {
            $data = $request->all();
            $data['school_id'] = session('school_id');
            $data['status'] = $request->input('status');
            if ($request->status == 1) {
                $data['approved_by'] = auth()->user()->id;
                $data['approved_date'] = Carbon::now();
            } elseif ($request->status == 0) {
                $data['rejected_by'] = auth()->user()->id;
            }

            $data['leave_days'] = $this->LeaveDaysCount($request);

            // Handle file update
            if ($request->hasFile('docs')) {
                // Delete existing file if it exists
                if ($staffLeave->docs && file_exists(public_path($staffLeave->docs))) {
                    unlink(public_path($staffLeave->docs));
                }
                $file = $request->file('docs');
                $subdirectory = 'uploads/leave_docs';
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path($subdirectory), $filename);
                $data['docs'] = $subdirectory . '/' . $filename;
            }
            $updateNow = $staffLeave->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Leave !');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Leave. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $staffLeave = StudentLeave::find($id);

        try {
            if ($staffLeave->docs && file_exists(public_path($staffLeave->docs))) {
                unlink(public_path($staffLeave->docs));
            }
            $updateNow = $staffLeave->delete();
            return redirect()->back()->withToastSuccess('Leave has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllStaffLeave(Request $request)
    {
        $staffLeave = $this->getForDataTable($request->all());

        return Datatables::of($staffLeave)
            ->escapeColumns([])
            ->addColumn('from_date', function ($staffLeave) {
                return $staffLeave->from_date;
            })
            ->addColumn('staff_name', function ($staffLeave) {
                return $staffLeave->staff ? $staffLeave->staff->user->f_name . ' ' . $staffLeave->staff->user->l_name : '';
            })
            ->addColumn('staff_employee_id', function ($staffLeave) {
                return $staffLeave->staff ? $staffLeave->staff->staff_employee_id : '';
            })
            ->addColumn('leave_type', function ($staffLeave) {
                return $staffLeave->leave_type ? $staffLeave->leave_type->type : '';
            })
            ->addColumn('to_date', function ($staffLeave) {
                return $staffLeave->to_date;
            })
            ->addColumn('docs', function ($staffLeave) {
                $originalFilename = pathinfo($staffLeave->docs, PATHINFO_FILENAME);
                $viewLink = '<a href="' . asset($staffLeave->docs) . '" target="_blank">View</a>';
                $downloadLink = '<a href="' . asset($staffLeave->docs) . '" download="' . $originalFilename . '">Download</a>';
                return $viewLink . ' | ' . $downloadLink;
            })

            ->addColumn('reason', function ($staffLeave) {
                return $staffLeave->reason;
            })
            ->addColumn('approved_user', function ($staffLeave) {
                return $staffLeave->approved_user ? $staffLeave->approved_user->f_name . ' ' . $staffLeave->approved_user->l_name : '';
            })
            ->addColumn('approved_date', function ($staffLeave) {
                return $staffLeave->approved_date;
            })
            ->addColumn('remarks', function ($staffLeave) {
                return $staffLeave->remarks;
            })
            ->addColumn('created_at', function ($staffLeave) {
                return $staffLeave->created_at->diffForHumans();
            })
            ->addColumn('status', function ($staffLeave) {
                return $staffLeave->status == 1 ? '<span class="btn-sm btn-success">Approve</span>' : '<span class="btn-sm btn-danger">Reject</span>';
            })
            ->addColumn('actions', function ($staffLeave) {
                return view('backend.school_admin.staff_leave.partials.controller_action', ['staffLeave' => $staffLeave])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = StaffLeave::where(function ($query) use ($request) {
            if (isset ($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}