<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Subject;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{

    public function index()
    {
        $page_title = 'Subject Listing';
        $subjects = Subject::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.subject.index', compact('page_title', 'subjects'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'subject_code' => 'required|unique:subjects',
            'subject' => 'required',
            'credit_hour' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $subject = $request->all();
            $subject['school_id'] = session('school_id');
            $savedData = Subject::create($subject);
            return redirect()->back()->withToastSuccess('Subject Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $subject = Subject::find($id);
        return view('backend.school_admin.subject.index', compact('subject'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'subject_code' => 'required',
            'subject' => 'required',
            'credit_hour' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $subject = Subject::findOrFail($id);

        try {
            $data = $request->all();
            $data['school_id'] = session('school_id');
            $updateNow = $subject->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Subject!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Subject. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $subject = Subject::find($id);

        try {
            $updateNow = $subject->delete();
            return redirect()->back()->withToastSuccess('Subject has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllSubjects(Request $request)
    {
        $subjects = $this->getForDataTable($request->all());

        return Datatables::of($subjects)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($subject) {
            //     return $subject->school_id;
            // })
            ->addColumn('subject_code', function ($subject) {
                return $subject->subject_code;
            })
            ->addColumn('subject', function ($subject) {
                return $subject->subject;
            })
            ->addColumn('credit_hour', function ($subject) {
                return $subject->credit_hour;
            })
            ->addColumn('created_at', function ($subject) {
                return $subject->created_at->diffForHumans();
            })
            ->addColumn('status', function ($subject) {
                return $subject->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($subject) {
                return view('backend.school_admin.subject.partials.controller_action', ['subject' => $subject])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $schoolId = session('school_id');

        $dataTableQuery = Subject::where('school_id', $schoolId)
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->get();

        return $dataTableQuery;
    }
}
