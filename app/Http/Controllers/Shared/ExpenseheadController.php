<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\Expensehead;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ExpenseheadController extends Controller
{

    public function index()
    {
        $page_title = 'Expense Head Listing';
        $expenseHeads = Expensehead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.expensehead.index', compact('page_title', 'expenseHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:expenseheads',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $expenseHead = $request->all();
            $savedData = Expensehead::create($expenseHead);
            return redirect()->back()->withToastSuccess('Expense Head Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $expenseHead = Expensehead::find($id);
        return view('backend.shared.expensehead.index', compact('expenseHead'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:expenseheads,name,' . $id,
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $expenseHead = Expensehead::findOrFail($id);

        try {
            $data = $request->all();
            $updateNow = $expenseHead->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Expense Head!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Expense Head. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $expenseHead = Expensehead::find($id);

        try {
            $updateNow = $expenseHead->delete();
            return redirect()->back()->withToastSuccess('Expense Head has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllExpenseshead(Request $request)
    {
        $expenseHeads = $this->getForDataTable($request->all());

        return Datatables::of($expenseHeads)
            ->escapeColumns([])
            ->addColumn('name', function ($expenseHead) {
                return $expenseHead->name;
            })
            ->addColumn('description', function ($expenseHead) {
                return $expenseHead->description;
            })
            ->addColumn('created_at', function ($expenseHead) {
                return $expenseHead->created_at->diffForHumans();
            })
            ->addColumn('status', function ($expenseHead) {
                return $expenseHead->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($expenseHead) {
                return view('backend.shared.expensehead.partials.controller_action', ['expenseHead' => $expenseHead])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Expensehead::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}