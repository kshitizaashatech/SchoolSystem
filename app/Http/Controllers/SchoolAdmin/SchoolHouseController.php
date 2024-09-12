<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolHouse;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class SchoolHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "List School Houses";

        return view('backend.school_admin.school_house.index', compact('page_title'));
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
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            // 'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $school_house = $request->all();
            $savedData = SchoolHouse::create($school_house);
            return redirect()->back()->withToastSuccess('School House Saved Successfully!');
        } catch (\Exception $e) {
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            // 'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $school_house = SchoolHouse::findOrFail($id);

        try {
            $data = $request->all();
            $updateNow = $school_house->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated School House!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update School House. Please try again')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $school_house = SchoolHouse::find($id);

        try {
            $updateNow = $school_house->delete();
            return redirect()->back()->withToastSuccess('School House has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }



    public function getAllHouses(Request $request)
    {
        $school_houses = $this->getForDataTable($request->all());

        return Datatables::of($school_houses)
            ->escapeColumns([])
            ->addColumn('name', function ($school_houses) {
                return $school_houses->name;
            })
            ->addColumn('created_at', function ($school_houses) {
                return $school_houses->created_at->diffForHumans();
            })
            ->addColumn('status', function ($school_houses) {
                return $school_houses->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($school_house) {
                return view('backend.school_admin.school_house.partials.controller_action', ['school_house' => $school_house])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = SchoolHouse::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
