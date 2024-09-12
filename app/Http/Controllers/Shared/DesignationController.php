<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Alert;
use Validator;

use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Designation Listing';
        return view('backend.shared.designation.index', compact('page_title'));
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
            'name' => 'required|unique:designations,name',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }


        try {
            $data = $request->all();
            $savedData = Designation::Create($data);
            return redirect()->back()->withToastSuccess('Designation Saved Successfully!');

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
        $designation = Designation::find($id);
        return view('backend.shared.designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:designations,name,' . $id,
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $designation = Designation::findorfail($id);
        try {
            $data = $request->all();
            $updateNow = $designation->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Designation!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Designation Please try again')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::find($id);
        try {
            $updateNow = $designation->delete();
            return redirect()->back()->withToastSuccess('Designation has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllDesignation(Request $request)
    {
        $designation = $this->getForDataTable($request->all());

        return Datatables::of($designation)
            ->escapeColumns([])
            ->addColumn('created_at', function ($designation) {
                return $designation->created_at->diffForHumans();
            })
            ->addColumn('designation', function ($designation) {
                return $designation->name;
            })
            ->addColumn('status', function ($designation) {
                return $designation->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';

            })

            ->addColumn('actions', function ($designation) {
                return view('backend.shared.designation.partials.controller_action', ['designation' => $designation])->render();
            })

            ->make(true);
    }


    /**
     * Get all the required data
     *
     * @return Response
     */
    public function getForDataTable($request)
    {
        /**
         * 
         */
        $dataTableQuery = Designation::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
