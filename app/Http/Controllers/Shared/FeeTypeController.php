<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\FeeType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FeeTypeController extends Controller
{
    public function index()
    {
        $page_title = 'Fee Type Listing';
        $feeTypes = FeeType::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.fee_type.index', compact('page_title', 'feeTypes'));
    }

    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:fee_types',
            'code' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $feeType = $request->all();
            $savedData = FeeType::create($feeType);
            return redirect()->back()->withToastSuccess('Fee Type Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $feeType = FeeType::find($id);
        return view('backend.shared.fee_type.index', compact('feeType'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:fee_types,name,' . $id,
            'code' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $feeType = FeeType::findOrFail($id);

        if (!$feeType) {
            return back()->withToastError('Fee Type not found.');
        }

        try {
            $data = $request->all();
            $feeType->update($data);

            return redirect()->back()->withToastSuccess('Fee Type Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Fee Type. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $feeType = FeeType::find($id);

        try {
            $feeType->delete();
            return redirect()->back()->withToastSuccess('Fee Type has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllFeeTypes(Request $request)
    {
        $feeTypes = $this->getForDataTable($request->all());

        return Datatables::of($feeTypes)
            ->escapeColumns([])
            ->addColumn('name', function ($feeType) {
                return $feeType->name;
            })
            ->addColumn('code', function ($feeType) {
                return $feeType->code;
            })
            ->addColumn('description', function ($feeType) {
                return $feeType->description;
            })
            ->addColumn('created_at', function ($feeType) {
                return $feeType->created_at->diffForHumans();
            })
            ->addColumn('status', function ($feeType) {
                return $feeType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($feeType) {
                return view('backend.shared.fee_type.partials.controller_action', ['feeType' => $feeType])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = FeeType::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
