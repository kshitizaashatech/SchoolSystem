<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\ClassTimetable;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClassTimetableController extends Controller
{
    public function index()
    {
        $page_title = 'Class Time Table Listing';
        $classtimetab = ClassTimetable::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.class_time_table.index', compact('page_title', 'classtimetab'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'academic_session_id' => 'required|numeric|exists:academic_sessions,id',
            // 'school_id' => 'required|numeric|exists:schools,id',
            // 'class_id' => 'required|numeric|exists:classes,id',
            // 'section_id' => 'required|numeric|exists:sections,id',
            // 'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            // 'subject_id' => 'required|numeric|exists:subjects,id',
            // 'staff_id' => 'required|numeric|exists:staffs,id',
            'day' => 'required|string',
            'time_from' => 'required|date',
            'time_to' => 'required|date',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'room_no' => 'required|string',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $classtimetab = $request->all();
            $classtimetab['academic_session_id'] = 1;
            $classtimetab['school_id'] = 1;
            $classtimetab['class_id'] = 1;
            $classtimetab['section_id'] = 1;
            $classtimetab['subject_group_id'] = 1;
            $classtimetab['subject_id'] = 1;
            $classtimetab['staff_id'] = 1;
            $savedData = ClassTimetable::Create($classtimetab);
            return redirect()->back()->withToastSuccess('Class Time Table Saved Successfully!');

        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $classtimetab = ClassTimetable::find($id);

        return view('backend.school_admin.class_time_table.index', compact('classtimetab'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            // 'academic_session_id' => 'required|numeric|exists:academic_sessions,id',
            // 'school_id' => 'required|numeric|exists:schools,id',
            // 'class_id' => 'required|numeric|exists:classes,id',
            // 'section_id' => 'required|numeric|exists:sections,id',
            // 'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            // 'subject_id' => 'required|numeric|exists:subjects,id',
            // 'staff_id' => 'required|numeric|exists:staffs,id',
            'day' => 'required|string',
            'time_from' => 'required|date',
            'time_to' => 'required|date',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'room_no' => 'required|string',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $classtimetab = ClassTimetable::findorfail($id);
        try {
            $data = $request->all();
            $data['academic_session_id'] = 1;
            $data['school_id'] = 1;
            $data['class_id'] = 1;
            $data['section_id'] = 1;
            $data['subject_group_id'] = 1;
            $data['subject_id'] = 1;
            $data['staff_id'] = 1;
            $updateNow = $classtimetab->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Class Time Table!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Class Time Table Please try again')->withInput();
    }
    public function destroy(string $id)
    {
        $classtimetab = ClassTimetable::find($id);
        try {
            $updateNow = $classtimetab->delete();
            return redirect()->back()->withToastSuccess('Class Time Table has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }
    public function getAllClassesTimeTable(Request $request)
    {
        $classtimetab = $this->getForDataTable($request->all());

        return Datatables::of($classtimetab)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($classtimetab) {
            //     return $classtimetab->school_id;
            // })
            ->addColumn('day', function ($classtimetab) {
                return $classtimetab->day;
            })
            ->addColumn('time_from', function ($classtimetab) {
                return $classtimetab->time_from;
            })
            ->addColumn('time_to', function ($classtimetab) {
                return $classtimetab->time_to;
            })
            ->addColumn('start_time', function ($classtimetab) {
                return $classtimetab->start_time;
            })
            ->addColumn('end_time', function ($classtimetab) {
                return $classtimetab->end_time;
            })
            ->addColumn('room_no', function ($classtimetab) {
                return $classtimetab->room_no;
            })
            ->addColumn('created_at', function ($classtimetab) {
                return $classtimetab->created_at->diffForHumans();
            })
            ->addColumn('status', function ($classtimetab) {
                return $classtimetab->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($classtimetab) {
                return view('backend.school_admin.class_time_table.partials.controller_action', ['classtimetab' => $classtimetab])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = ClassTimetable::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
