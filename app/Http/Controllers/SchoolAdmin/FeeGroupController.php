<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeeGroup;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class FeeGroupController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Fee Group Listing';
        $feeGroups = FeeGroup::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.fee_group.index', compact('page_title', 'feeGroups'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'description' => 'required',

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $feeGroup = $request->all();
            $savedData = FeeGroup::create($feeGroup);
            return redirect()->back()->withToastSuccess('Fee Group Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function edit(string $id)
    {
        $feeGroup = FeeGroup::find($id);
        return view('backend.school_admin.fee_group.index', compact('feeGroup'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'description' => 'required',

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $feeGroup = FeeGroup::findOrFail($id);

        if (!$feeGroup) {
            return back()->withToastError('Fee Group not found.');
        }

        try {
            $data = $request->all();
            $feeGroup->update($data);

            return redirect()->back()->withToastSuccess('Fee Group Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Fee Group. Please try again')->withInput();
    }


    public function destroy($id)
    {
        $feeGroup = FeeGroup::find($id);

        try {
            $feeGroup->delete();
            return redirect()->back()->withToastSuccess('Fee Group has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllFeeGroups(Request $request)
    {
        $feeGroups = $this->getForDataTable($request->all());

        return Datatables::of($feeGroups)
            ->escapeColumns([])
            ->addColumn('name', function ($feeGroup) {
                return $feeGroup->name;
            })
            ->addColumn('code', function ($feeGroup) {
                return $feeGroup->code;
            })
            ->addColumn('description', function ($feeGroup) {
                return $feeGroup->description;
            })
            ->addColumn('created_at', function ($feeGroup) {
                return $feeGroup->created_at->diffForHumans();
            })

            ->addColumn('actions', function ($feeGroup) {
                return view('backend.school_admin.fee_group.partials.controller_action', ['feeGroup' => $feeGroup])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = FeeGroup::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
