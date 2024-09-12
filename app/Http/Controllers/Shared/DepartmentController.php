<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Alert;
use App\Models\Department;
use Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Department Listing';
        return view('backend.shared.department.index', compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        try {
            $data = $request->all();
            $savedData = Department::Create($data);
            return redirect()->back()->withToastSuccess('Department Saved Successfully!');
        } catch (\Exception $e) {
            // return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::find($id);
        return view('backend.shared.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,' . $id,
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $department = Department::findorfail($id);
        try {
            $data = $request->all();
            $updateNow = $department->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Department!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Department Please try again')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::find($id);
        try {
            $updateNow = $department->delete();
            return redirect()->back()->withToastSuccess('Department has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }


    public function getAllDepartment(Request $request)
    {
        $department = $this->getForDataTable($request->all());

        return Datatables::of($department)
            ->escapeColumns([])
            ->addColumn('created_at', function ($department) {
                return $department->created_at->diffForHumans();
            })
            ->addColumn('department', function ($department) {
                return $department->name;
            })
            ->addColumn('status', function ($department) {
                return $department->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($department) {
                return view('backend.shared.department.partials.controller_action', ['department' => $department])->render();
            })
            // dd($department);
            ->make(true);
    }
    public function getForDataTable($request)
    {
        /**
         * 
         */
        $dataTableQuery = Department::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
