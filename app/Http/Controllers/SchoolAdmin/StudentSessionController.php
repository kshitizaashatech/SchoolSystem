<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StudentSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StudentSessionController extends Controller
{
    public function index()
    {
        $page_title = 'Student Session Listing';
        $studentSessions = StudentSession::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.student_session.index', compact('page_title', 'studentSessions'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $studentSessionData = $request->all(); // Adjust as needed
            // Assuming default values for most fields
            $studentSessionData['user_id'] = 1;
            $studentSessionData['academic_session_id'] = 1;
            $studentSessionData['school_id'] = 1;
            $studentSessionData['class_id'] = 1;
            $studentSessionData['section_id'] = 1;
            $savedData = StudentSession::create($studentSessionData);
            return redirect()->back()->withToastSuccess('Student Session Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $studentSession = StudentSession::find($id);
        return view('backend.school_admin.student_session.index', compact('studentSession'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $studentSession = StudentSession::findOrFail($id);

        try {
            $studentSessionData = $request->all(); // Adjust as needed
            // Assuming default values for most fields
            $studentSessionData['user_id'] = 1;
            $studentSessionData['academic_session_id'] = 1;
            $studentSessionData['school_id'] = 1;
            $studentSessionData['class_id'] = 1;
            $studentSessionData['section_id'] = 1;
            $updateNow = $studentSession->update($studentSessionData);
            return redirect()->back()->withToastSuccess('Successfully Updated Student Session!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Student Session. Please try again')->withInput();
    }
    public function destroy($id)
    {
        $studentSession = StudentSession::find($id);
        try {
            $updateNow = $studentSession->delete();
            return redirect()->back()->withToastSuccess('Student Session has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }
    public function getAllStudentsession(Request $request)
    {
        $studentsession = $this->getForDataTable($request->all());

        return Datatables::of($studentsession)
            ->escapeColumns([])

            ->addColumn('created_at', function ($stdsession) {
                return $stdsession->created_at->diffForHumans();
            })
            ->addColumn('status', function ($subject) {
                return $subject->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($stdsession) {
                return view('backend.school_admin.student_session.partials.controller_action', ['stdsession' => $stdsession])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = StudentSession::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
