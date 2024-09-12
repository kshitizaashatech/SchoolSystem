<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InventoryHead;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class InventoryHeadController extends Controller
{
    public function index()
    {
        $page_title = 'Inventory Head Listing';
        $inventoryHeads = InventoryHead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.inventoryhead.index', compact('page_title', 'inventoryHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:inventory_head',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $inventoryHead = $request->all();
            // $incomeHead['school_id'] = 1;
            $savedData = InventoryHead::create($inventoryHead);
            return redirect()->back()->withToastSuccess('Income Head Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $inventoryHead = InventoryHead::find($id);
        return view('backend.shared.inventoryhead.index', compact('inventoryHead'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:inventory_head,name,' . $id,
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $inventoryHead = InventoryHead::findOrFail($id);

        try {
            $data = $request->all();
            // $data['school_id'] = 1;
            $updateNow = $inventoryHead->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Inventory Head!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Income Head. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $inventoryHead = InventoryHead::find($id);

        try {
            $updateNow = $inventoryHead->delete();
            return redirect()->back()->withToastSuccess('Inventory Head has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllInventoryhead(Request $request)
    {
        $inventoryHeads = $this->getForDataTable($request->all());

        return Datatables::of($inventoryHeads)
            ->escapeColumns([])
            ->addColumn('name', function ($inventoryHead) {
                return $inventoryHead->name;
            })
            ->addColumn('description', function ($inventoryHead) {
                return $inventoryHead->description;
            })
            ->addColumn('created_at', function ($inventoryHead) {
                return $inventoryHead->created_at->diffForHumans();
            })
            ->addColumn('status', function ($inventoryHead) {
                return $inventoryHead->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($inventoryHead) {
                return view('backend.shared.inventoryhead.partials.controller_action', ['inventoryHead' => $inventoryHead])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = InventoryHead::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
