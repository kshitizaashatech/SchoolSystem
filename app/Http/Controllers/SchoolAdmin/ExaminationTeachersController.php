<?php

namespace App\Http\Controllers\SchoolAdmin;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Role;
use App\Models\Staff;
use App\Models\UserType;
use App\Models\Examination;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\ExaminationTeachers;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ExaminationTeachersController extends Controller
{
    public function getTeachers()
    {
        $schoolId = session('school_id');
        $teachers = User::where('role_id', 6)
            ->where('school_id', $schoolId)
            ->select('id', 'f_name', 'l_name')
            ->get()
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->f_name . ' ' . $teacher->l_name
                ];
            });
    
        return response()->json($teachers);
    }
    
    public function assignTeachers(string $id)
{
    $examinations = Examination::find($id);
    if (!$examinations) {
        abort(404, 'Examination not found');
    }

    $page_title = "Assign Teachers To " . $examinations->exam;
    $schoolId = session('school_id');

    if (!$schoolId) {
        abort(404, 'School ID not found in session');
    }

    $classes = Classg::where('school_id', $schoolId)
        ->orderBy('created_at', 'desc')
        ->get();

    $staffTypeId = UserType::where('title', 'staffs')->value('id');
    $teacherRole = Role::where('name', 'Teacher')->first();
    $teacherRoleId = $teacherRole ? $teacherRole->id : null;

    // dd($staffTypeId, $teacherRoleId);

    $teachers = User::where('user_type_id', $staffTypeId)
        ->whereHas('staff', function ($query) use ($teacherRoleId, $schoolId) {
            $query->where('role_id', $teacherRoleId)  
                  ->where('school_id', $schoolId);
        })
        ->select('id', 'f_name', 'l_name')
        ->get()
        ->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->f_name . ' ' . $teacher->l_name];
        });

    $examinationTeachers = ExaminationTeachers::all();

    return view('backend.school_admin.examination.teacher.create', compact('page_title', 'classes', 'examinations', 'teachers', 'examinationTeachers'));
}

    public function storeAssignTeachers(Request $request)
    {

        try {
            // Retrieve data from the request
            $examinationId = $request->input('examination_id');
            $classId = $request->input('class_id');
            $sectionId = $request->input('section_id');
            $teacherId = $request->input('user_id');
            // Update existing record or create a new one
            ExaminationTeachers::updateOrCreate(
                [
                    'examination_id' => $examinationId,
                    'class_id' => $classId,
                    'section_id' => $sectionId
                ],
                [
                    'user_id' => $teacherId,
                    'student_session_id' => 1,
                ]
            );
            return response()->json(['message' => 'Record stored successfully']);
        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => 'Record not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error storing assigned teachers: ' . $e->getMessage());
            return response()->json(['error' => 'Error processing data: ' . $e->getMessage()], 500);
        }
    }


    public function getAllExaminationsTeachers(Request $request)
    {
        $examinationTeachers = $this->getForDataTable($request->all());

        return Datatables::of($examinationTeachers)
            ->escapeColumns([])

            ->addColumn('class_id', function ($examinationTeachers) {
                return $examinationTeachers->class->class;
            })

            ->addColumn('section_id', function ($examinationTeachers) {
                return $examinationTeachers->section->section_name;
            })

            ->addColumn('user_id', function ($examinationTeachers) {
                return $examinationTeachers->user->f_name;
            })

            ->addColumn('actions', function ($examinationTeachers) {
                return view('backend.school_admin.examination.teacher.partials.controller_action', ['examinationTeachers' => $examinationTeachers])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = ExaminationTeachers::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
    public function edit(Request $request, $id)
    {
        try {
            $page_title = 'Edit Examination Teacher';
            $examinations = Examination::find($id);
            $schoolId = session('school_id');
            $classes = Classg::where('school_id', $schoolId)
                ->orderBy('created_at', 'desc')
                ->get();
            $examTeacher = ExaminationTeachers::findOrFail($id);
            $teachers = User::where('role_id', 6)
                ->where('school_id', $schoolId)
                ->get()
                ->pluck(DB::raw("CONCAT(f_name, ' ', l_name)"), 'id')
                ->toArray();
            $examinationTeachers = ExaminationTeachers::all();
            $sections = Section::all();
            return view('backend.school_admin.examination.teacher.update', compact('examTeacher', 'classes', 'teachers', 'examinationTeachers', 'examinations', 'examTeacher', 'page_title', 'sections'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error editing record: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Retrieve the ExaminationTeachers record by ID
            $examTeacher = ExaminationTeachers::findOrFail($id);

            // Retrieve the examination_id from the request
            $examinationId = $request->input('examination_id');

            // Update the record with the new data from the request
            $examTeacher->update($request->all());

            return response()->json(['message' => 'Record updated successfully']);
        } catch (ModelNotFoundException $e) {
            // Return error response if the record is not found
            return response()->json(['error' => 'Record not found.'], 404);
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['error' => 'Error updating record: ' . $e->getMessage()], 500);
        }
    }


    public function deleteAssignTeachers($id)
    {
        try {

            // Find the ExaminationTeachers record by ID and delete it
            $examTeacher = ExaminationTeachers::findOrFail($id);
            $examTeacher->delete();

            return redirect()->back()->withToastSuccess('Exam Teacher has been Successfully Deleted!');
        } catch (ModelNotFoundException $e) {
            // Return error response if the record is not found
            return redirect()->back()->withToastSuccess('Record not found.');
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['error' => 'Error deleting record: ' . $e->getMessage()], 500);
        }
    }
}
