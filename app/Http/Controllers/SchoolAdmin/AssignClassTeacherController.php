<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use App\Models\AcademicSession;
use Validator;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\School;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\AssignClassTeacher;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AssignClassTeacherController extends Controller
{
    public function index()
    {
        $page_title = 'ClassTeacher Listing';
        $academicmanagement = AcademicSession::orderBy('created_at', 'desc')->paginate(10);
        $classmanagement = Classg::orderBy('created_at', 'desc')->paginate(10);
        $sectionmanagement = Section::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.assign_class_teacher.index', compact('page_title', 'classmanagement', 'sectionmanagement', 'academicmanagement'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'academic_session_id' => 'required|string',
            'class_id' => 'required|string',
            'section_id' => 'required|string',
            // 'class_teacher_id' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $classmanagementData = $request->all();
            $classmanagementData['class_teacher_id'] = 1; // Default class_teacher_id
            $savedData = AssignClassTeacher::create($classmanagementData);

            return redirect()->back()->withToastSuccess('AssignClassTeacher Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $classmanagement = AssignClassTeacher::find($id);
        return view('backend.school_admin.assign_class_teacher.index', compact('income'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'academic_session_id' => 'required|string',
            'class_id' => 'required|string',
            'section_id' => 'required|string',
            // 'class_teacher_id' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $classmanagement = AssignClassTeacher::findOrFail($id);

        try {
            $data = $request->all();
            $data['class_teacher_id'] = 1; // Default class_teacher_id
            $updateNow = $classmanagement->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated AssignClassTeacher!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update AssignClassTeacher. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $classmanagement = AssignClassTeacher::find($id);

        try {
            $updateNow = $classmanagement->delete();
            return redirect()->back()->withToastSuccess('AssignClassTeacher has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }
    public function getAllAssignClassTeacher(Request $request)
    {
        $classmanagements = $this->getForDataTable($request->all());

        return Datatables::of($classmanagements)
            ->escapeColumns([])
            ->addColumn('academic_session_id', function ($classmanagement) {
                return $classmanagement->academicSession->session;
            })
            ->addColumn('class_id', function ($classmanagement) {
                return $classmanagement->classes->class;
            })
            ->addColumn('section_id', function ($classmanagement) {
                return $classmanagement->sections->section_name;
            })
            ->addColumn('created_at', function ($classmanagement) {
                return $classmanagement->created_at->diffForHumans();
            })
            ->addColumn('status', function ($attendanceType) {
                return $attendanceType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($classmanagement) {
                return view('backend.school_admin.assign_class_teacher.partials.controller_action', ['classmanagement' => $classmanagement])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = AssignClassTeacher::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
