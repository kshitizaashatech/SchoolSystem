<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
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

class StudentLeaveController extends Controller
{
    public function index()
    {
        $page_title = 'Student Leave Listing';
        $schoolId = session('school_id');
        // $studentLeave = StudentLeave::orderBy('created_at', 'desc')->paginate(10);
        $classmanagement = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $sectionmanagement = Section::orderBy('created_at', 'desc')->paginate(10);
        $studentmanagement = Student::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.student_leave.index', compact('page_title', 'classmanagement', 'sectionmanagement', 'studentmanagement'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'leave_type_id' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'docs' => 'nullable|file|mimes:pdf,doc,docx',
            // 'reason' => 'required|string',
            // 'approved_by' => 'required|integer',
            // 'approved_date' => 'nullable|date',
            // 'remarks' => 'nullable|string',
            'status' => 'required|boolean',
            'class_id' => 'required|string',
            'section_id' => 'required|string',
            'student_id' => 'required|string'
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $studentLeaveData = $request->all();
            $studentLeaveData['school_id'] = session('school_id');
            if ($request->status == 1) {
                $studentLeaveData['approved_by'] = auth()->user()->id;
                $studentLeaveData['approved_date'] = Carbon::now();
            } elseif ($request->status == 0) {
                $studentLeaveData['rejected_by'] = auth()->user()->id;
            }

            if ($request->hasFile('docs')) {
                $file = $request->file('docs');
                $subdirectory = 'uploads/leave_docs';
                $filename = $file->getClientOriginalName();
                $file->move(public_path($subdirectory), $filename);
                $studentLeaveData['docs'] = $subdirectory . '/' . $filename;
            }
            $savedData = StudentLeave::create($studentLeaveData);

            return redirect()->back()->withToastSuccess('Student Leave Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit($id)
    {
        // $studentLeave = StudentLeave::find($id);
        // return view('backend.school_admin.student_leave.index', compact('leaveType'));
        $studentLeave = StudentLeave::findOrFail($id);
        $classmanagement = Classg::all();
        $sectionmanagement = Section::all();
        $studentmanagement = Student::all();

        return view('backend.school_admin.student_leave.index', compact('studentLeave', 'classmanagement', 'sectionmanagement', 'studentmanagement'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'docs' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|boolean',
            'class_id' => 'required|string',
            'section_id' => 'required|string',
            'student_id' => 'required|string'
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $studentLeave = StudentLeave::findOrFail($id);

        try {
            // Override the approved_by field with the current user's ID
            $data = $request->all();
            $data['school_id'] = session('school_id');
            if ($request->status == 1) {
                $data['approved_by'] = auth()->user()->id;
                $data['approved_date'] = Carbon::now();
            } elseif ($request->status == 0) {
                $data['rejected_by'] = auth()->user()->id;
            }

            // Handle file update
            if ($request->hasFile('docs')) {
                // Delete existing file if it exists
                if ($studentLeave->docs && file_exists(public_path($studentLeave->docs))) {
                    unlink(public_path($studentLeave->docs));
                }
                $file = $request->file('docs');
                $subdirectory = 'uploads/leave_docs';
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path($subdirectory), $filename);
                $data['docs'] = $subdirectory . '/' . $filename;
            }
            $updateNow = $studentLeave->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Leave !');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Leave. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $studentLeave = StudentLeave::find($id);

        try {
            if ($studentLeave->docs && file_exists(public_path($studentLeave->docs))) {
                unlink(public_path($studentLeave->docs));
            }
            $updateNow = $studentLeave->delete();
            return redirect()->back()->withToastSuccess('Leave has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllStudentLeave(Request $request)
    {
        $studentLeave = $this->getForDataTable($request->all());

        return Datatables::of($studentLeave)
            ->escapeColumns([])
            ->addColumn('from_date', function ($studentLeave) {
                return $studentLeave->from_date;
            })
            ->addColumn('class_id', function ($studentLeave) {
                return $studentLeave->classes->class;
            })
            ->addColumn('section_id', function ($studentLeave) {
                return $studentLeave->sections->section_name;
            })
            ->addColumn('student_id', function ($studentLeave) {
                return $studentLeave->student->user->f_name . ' ' . $studentLeave->student->user->l_name;
            })
            ->addColumn('to_date', function ($studentLeave) {
                return $studentLeave->to_date;
            })
            ->addColumn('docs', function ($studentLeave) {
                $originalFilename = pathinfo($studentLeave->docs, PATHINFO_FILENAME);
                $viewLink = '<a href="' . asset($studentLeave->docs) . '" target="_blank">View</a>';
                $downloadLink = '<a href="' . asset($studentLeave->docs) . '" download="' . $originalFilename . '">Download</a>';
                return $viewLink . ' | ' . $downloadLink;
            })

            ->addColumn('reason', function ($studentLeave) {
                return $studentLeave->reason;
            })
            ->addColumn('approved_by', function ($studentLeave) {
                return $studentLeave->approved_user ? $studentLeave->approved_user->f_name . ' ' . $studentLeave->approved_user->l_name : '';
            })
            ->addColumn('approved_date', function ($studentLeave) {
                return $studentLeave->approved_date;
            })
            ->addColumn('remarks', function ($studentLeave) {
                return $studentLeave->remarks;
            })
            ->addColumn('created_at', function ($studentLeave) {
                return $studentLeave->created_at->diffForHumans();
            })
            ->addColumn('status', function ($studentLeave) {
                return $studentLeave->status == 1 ? '<span class="btn-sm btn-success">Approve</span>' : '<span class="btn-sm btn-danger">Reject</span>';
            })
            ->addColumn('actions', function ($studentLeave) {
                return view('backend.school_admin.student_leave.partials.controller_action', ['studentLeave' => $studentLeave])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = StudentLeave::where(function ($query) use ($request) {
            if (isset ($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}