<?php

namespace App\Http\Controllers\MunicipalityAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Inventory;
use Carbon\Carbon;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Yajra\DataTables\DataTables;

class InventoryReportController extends Controller
{
    public function index()
    {
        $schools = School::all(); 
        return view('backend.municipality_admin.report.inventoryreport.index', compact('schools'));
    }

    public function report(Request $request)
    {
        $inputDate = $request->input('date', Carbon::today()->format('Y-m-d')); // Default to today's date if not provided
        $date = Carbon::parse($inputDate)->format('Y-m-d');
        $schools = School::all(); // Fetch all schools
        $schoolInventories = Inventory::whereDate('created_at', $date)->get();
        return view('backend.municipality_admin.report.inventoryreport.index', compact('schoolInventories', 'date', 'schools'));
    }

    public function getData(Request $request)
    {
        $inputDate = $request->input('date', Carbon::today()->format('Y-m-d'));
        $schoolId = $request->input('school_id');
        $inventoryName = $request->input('inventory_name');

        $date = Carbon::parse($inputDate)->format('Y-m-d');

        $query = Inventory::with(['school', 'inventoryHead'])
            ->whereDate('created_at', $date)
            ->when($schoolId, function ($query, $schoolId) {
                return $query->where('school_id', $schoolId);
            })
            ->when($inventoryName, function ($query, $inventoryName) {
                return $query->where('name', 'like', '%' . $inventoryName . '%');
            });

        return DataTables::of($query)
            ->addColumn('school_name', function ($inventory) {
                return $inventory->school ? $inventory->school->name : 'N/A';
            })
            ->addColumn('inventory_head_name', function ($inventory) {
                return $inventory->inventoryHead ? $inventory->inventoryHead->name : 'N/A';
            })
            ->addColumn('item_name', function ($inventory) {
                return $inventory->name;
            })
            ->addColumn('action', function ($inventory) {
                return '<a href="' . route('admin.municipalityAdmin.inventoryReport.view', $inventory->id) . '" class="btn btn-primary">View</a>';
            })
            ->rawColumns(['school_name', 'inventory_head_name', 'item_name', 'unit', 'description', 'status', 'action'])
            ->make(true);
    }

    public function view($id)
    {
        $inventory = Inventory::with(['school', 'inventoryHead'])->findOrFail($id);
        return view('backend.municipality_admin.report.inventoryreport.view', compact('inventory'));
    }
}
