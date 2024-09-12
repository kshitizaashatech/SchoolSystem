<?php
namespace App\Http\Controllers\SchoolAdmin;
use Alert;
use App\Models\InventoryHead;
use Validator;
use Carbon\Carbon;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class InventoriesController extends Controller
{
    public function index()
    {
        $page_title = 'Inventory Listing';
        $inventorieshead = InventoryHead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.inventory.index', compact('page_title', 'inventorieshead'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'inventory_head_id' => 'required|string',
            'name' => 'required|string',
            'unit' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {

            $inventoryData = $request->all();
            $inventoryData['school_id'] = Auth::user()->school_id; 
            $savedData = Inventory::create($inventoryData);
            $inventoryId = $savedData->id;
            
            return redirect()->back()->withToastSuccess('Inventory Saved Successfully!');

        } catch (\Exception $e) {

            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $inventory= Inventory::find($id);
        return view('backend.school_admin.inventory.index', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'inventory_head_id' => 'required',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);
    
        $inventory = Inventory::findOrFail($id);
        $inventory->inventory_head_id = $request->inventory_head_id;
        $inventory->name = $request->name;
        $inventory->unit = $request->unit;
        $inventory->description = $request->description;
        $inventory->status = $request->status;
        $inventory->save();
    
        return redirect()->route('admin.inventories.index')->with('success', 'Inventory updated successfully');
    }

    public function destroy(string $id)
    {
        $inventory = Inventory::find($id);
        try {
            $updateNow = $inventory->delete();
            return redirect()->back()->withToastSuccess('Inventory has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllInventories(Request $request)
    {
        $inventories = $this->getForDataTable($request->all());
        return Datatables::of($inventories)
            ->escapeColumns([])
            ->addColumn('inventory_head_id', function ($inventory) {
                return $inventory->inventoryHead->name; //incomeHead is  public function incomeHead(){ } relationship from Income.php Model
            })
            ->addColumn('name', function ($inventory) {
                return $inventory->name;
            })
            ->addColumn('unit', function ($inventory) {
                return $inventory->unit;
            })
            ->addColumn('description', function ($inventory) {
                return $inventory->description;
            })
            ->addColumn('created_at', function ($inventory) {
                return $inventory->created_at->diffForHumans();
            })
            ->addColumn('status', function ($inventory) {
                return $inventory->status == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($inventory) {
                return view('backend.school_admin.inventory.partials.controller_action', ['inventory' => $inventory])->render();
            })
            ->make(true);
    }
    public function getForDataTable($request)
    {

        $schoolId = session('school_id');
        $dataTableQuery = Inventory::where('school_id', $schoolId) 
        ->where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();
        return $dataTableQuery;
    }
}




