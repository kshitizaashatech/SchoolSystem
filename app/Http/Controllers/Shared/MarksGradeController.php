<?php

namespace App\Http\Controllers\Shared;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\MarksGrade;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MarksGradeController extends Controller
{
    //

    public function index()
    {
        $page_title = 'Marks Grade Listing';
        return view('backend.shared.marks_grade.index', compact('page_title'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'grade_name' => 'required|string',
            'grade_points' => 'required|string',
            'percentage_from' => 'required|string',
            'percentage_to' => 'required|string',
            'achievement_description' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $marksgrade = $request->all();
            $savedData = MarksGrade::create($marksgrade);
            return redirect()->back()->withToastSuccess('Marks Grade Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $marksgrade = MarksGrade::find($id);
        return view('backend.shared.marks_grade.index', compact('marksgrade'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'grade_name' => 'required|string',
            'grade_points' => 'required|string',
            'percentage_from' => 'required|string',
            'percentage_to' => 'required|string',
            'achievement_description' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $marksgrade = MarksGrade::findOrFail($id);

        try {
            $data = $request->all();

            $updateNow = $marksgrade->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Marks Grade!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Marks Grade. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $marksgrade = MarksGrade::find($id);

        try {
            $updateNow = $marksgrade->delete();
            return redirect()->back()->withToastSuccess('Marks Grade has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }


    public function getAllMarksGrade(Request $request)
    {
        $marksgrade = $this->getForDataTable($request->all());

        return Datatables::of($marksgrade)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($subject) {
            //     return $subject->school_id;
            // })
            ->addColumn('grade_name', function ($marksgrade) {
                return $marksgrade->grade_name;
            })
            ->addColumn('grade_points', function ($marksgrade) {
                return $marksgrade->grade_points;
            })
            ->addColumn('percentage_from', function ($marksgrade) {
                return $marksgrade->percentage_from;
            })
            ->addColumn('percentage_to', function ($marksgrade) {
                return $marksgrade->percentage_to;
            })
            ->addColumn('achievement_description', function ($marksgrade) {
                return $marksgrade->achievement_description;
            })
            ->addColumn('status', function ($marksgrade) {
                return $marksgrade->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('created_at', function ($marksgrade) {
                return $marksgrade->created_at->diffForHumans();
            })

            ->addColumn('actions', function ($marksgrade) {
                return view('backend.shared.marks_grade.partials.controller_action', ['marksgrade' => $marksgrade])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = MarksGrade::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
