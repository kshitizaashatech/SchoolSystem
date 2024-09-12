<?php

namespace App\Http\Controllers\Shared;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\MarksDivision;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class MarksDivisionController extends Controller
{
    //
    public function index(){
        $page_title = 'Marks Division Listing';
        return view('backend.shared.marks_division.index', compact('page_title'));

    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'points' =>'required|string',
            'marks_from' => 'required|string',
            'marks_to' => 'required|string',
            'description' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $marksdivision = $request->all();
            $savedData = MarksDivision::create($marksdivision);
            return redirect()->back()->withToastSuccess('MarksDivision Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $marksdivision = MarksDivision::find($id);
        return view('backend.shared.marks_division.index', compact('marksdivision'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'points' => 'required|string',
            'marks_from' => 'required|string',
            'marks_to' => 'required|string',
            'description' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $marksdivision = MarksDivision::findOrFail($id);

        try {
            $data = $request->all();

            $updateNow = $marksdivision->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Marks Division!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Marks Division. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $marksdivision = MarksDivision::find($id);

        try {
            $updateNow = $marksdivision->delete();
            return redirect()->back()->withToastSuccess('Marks Division has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }


    public function getAllMarksDivision(Request $request)
    {
        $marksdivision = $this->getForDataTable($request->all());

        return Datatables::of($marksdivision)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($subject) {
            //     return $subject->school_id;
            // })
            ->addColumn('name', function ($marksdivision) {
                return $marksdivision->name;
            })
            ->addColumn('points', function ($marksdivision) {
                return $marksdivision->points;
            })
            ->addColumn('marks_from', function ($marksdivision) {
                return $marksdivision->marks_from;
            })
            ->addColumn('marks_to', function ($marksdivision) {
                return $marksdivision->marks_to;
            })
            ->addColumn('description', function ($marksdivision) {
                return $marksdivision->description;
            })
            ->addColumn('status', function ($marksdivision) {
                return $marksdivision->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('created_at', function ($marksdivision) {
                return $marksdivision->created_at->diffForHumans();
            })

            ->addColumn('actions', function ($marksdivision) {
                return view('backend.shared.marks_division.partials.controllers_action', ['marksdivision' => $marksdivision])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = MarksDivision::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }



}