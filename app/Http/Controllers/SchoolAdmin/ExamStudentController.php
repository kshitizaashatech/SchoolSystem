<?php

namespace App\Http\Controllers\SchoolAdmin;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\ExamStudent;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ExamStudentController extends Controller
{
    //
    public function index(){
        $page_title = "List Exam Student";
        return view('backend.school_admin.exam_student.index', compact('page_title'));


    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'filled|numeric',

            'teachers_remarks' => 'required|integer',
            'rank' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $exam_student = $request->all();
            $exam_student['examination_id'] = 1;
            $exam_student['student_id'] = 1;
            $exam_student['student_session_id'] = 1;


            $savedData = ExamStudent::Create($exam_student);
            return redirect()->back()->withToastSuccess('Exam Student Saved Successfully!');

        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $exam_student = ExamStudent::find($id);

        return view('backend.school_admin.exam_student.index', compact('exam_student'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'teachers_remarks' => 'required|integer',
            'rank' => 'required|integer',
            'is_active' => 'required|boolean',

        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $exam_student = ExamStudent::findorfail($id);
        try {
            $data = $request->all();
            $exam_student['examination_id'] = 1;
            $exam_student['student_id'] = 1;
            $exam_student['student_session_id'] = 1;

            $updateNow = $exam_student->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Exam Student!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Exam Student Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $exam_student = ExamStudent::find($id);

        try {
            $updateNow = $exam_student->delete();
            return redirect()->back()->withToastSuccess('Exam Student has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }


    public function getAllExamStudent(Request $request)
    {
        $exam_student = $this->getForDataTable($request->all());

        return Datatables::of($exam_student)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($subject) {
            //     return $subject->school_id;
            // })
            ->addColumn('teachers_remarks', function ($exam_student) {
                return $exam_student->teachers_remarks;
            })
            ->addColumn('rank', function ($exam_student) {
                return $exam_student->rank;
            })

            ->addColumn('created_at', function ($exam_student) {
                return $exam_student->created_at->diffForHumans();
            })
            ->addColumn('status', function ($exam_student) {
                return $exam_student->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($exam_student) {
                return view('backend.school_admin.exam_student.partials.controller_action', ['exam_student' => $exam_student])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = ExamStudent::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

}
