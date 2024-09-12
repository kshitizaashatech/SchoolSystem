<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ExamScheduleController extends Controller
{
    //
    public function index()
    {
        $page_title = "List Exam Schedule";
        return view('backend.school_admin.exam_schedule.index', compact('page_title'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'filled|numeric',
            'exam_date' => 'required|string',
            'exam_time' => 'required|string',
            'exam_duration' => 'required|string',
            'room_no' => 'required|string',
            'full_marks' => 'required|integer',
            'pass_marks' => 'required|integer',
            'credit_hour' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $exam_schedule = $request->all();
            $exam_schedule['examination_id'] = 1;
            $exam_schedule['subject_id'] = 1;
            $exam_schedule['class_id'] = 1;
            $exam_schedule['section_id'] = 1;

            $savedData = ExamSchedule::Create($exam_schedule);
            return redirect()->back()->withToastSuccess('Exam Schedule Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $exam_schedule = ExamSchedule::find($id);

        return view('backend.school_admin.exam_schedule.index', compact('exam_schedule'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'exam_date' => 'required|string',
            'exam_time' => 'required|string',
            'exam_duration' => 'required|string',
            'room_no' => 'required|string',
            'full_marks' => 'required|integer',
            'pass_marks' => 'required|integer',
            'credit_hour' => 'required|integer',
            'is_active' => 'required|boolean',

        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $exam_schedule = ExamSchedule::findorfail($id);
        try {
            $data = $request->all();
            $data['examination_id'] = 1;
            $data['subject_id'] = 1;
            $data['class_id'] = 1;
            $data['section_id'] = 1;

            $updateNow = $exam_schedule->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Exam Schedule!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Exam Schedule Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $exam_schedule = ExamSchedule::find($id);

        try {
            $updateNow = $exam_schedule->delete();
            return redirect()->back()->withToastSuccess('Exam Schedule has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllExamSchedules(Request $request)
    {
        $exam_schedule = $this->getForDataTable($request->all());

        return Datatables::of($exam_schedule)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($subject) {
            //     return $subject->school_id;
            // })
            ->addColumn('exam_date', function ($exam_schedule) {
                return $exam_schedule->exam_date;
            })
            ->addColumn('exam_time', function ($exam_schedule) {
                return $exam_schedule->exam_time;
            })
            ->addColumn('exam_duration', function ($exam_schedule) {
                return $exam_schedule->exam_duration;
            })
            ->addColumn('room_no', function ($exam_schedule) {
                return $exam_schedule->room_no;
            })
            ->addColumn('full_marks', function ($exam_schedule) {
                return $exam_schedule->full_marks;
            })
            ->addColumn('pass_marks', function ($exam_schedule) {
                return $exam_schedule->pass_marks;
            })
            ->addColumn('created_at', function ($exam_schedule) {
                return $exam_schedule->created_at->diffForHumans();
            })
            ->addColumn('status', function ($exam_schedule) {
                return $exam_schedule->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($exam_schedule) {
                return view('backend.school_admin.exam_schedule.partials.controller_action', ['exam_schedule' => $exam_schedule])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = ExamSchedule::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
