<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use App\Models\Expensehead;
use Validator;
use Carbon\Carbon;
use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $page_title = 'Expense Listing';
        $expenseshead = Expensehead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.expense.index', compact('page_title', 'expenseshead'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'expensehead_id' => 'required|string',
            'name' => 'required|string',
            'invoice_number' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:jpeg,pdf',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $expenseData = $request->all();
            $expenseData['school_id'] = Auth::user()->school_id;
            $savedData = Expense::create($expenseData);

            return redirect()->back()->withToastSuccess('Expenses Saved Successfully!');

        } catch (\Exception $e) {

            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $expense = Expense::find($id);
        return view('backend.school_admin.expense.index', compact('expense'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'expensehead_id' => 'required|string',
            'name' => 'required|string',
            'invoice_number' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:jpeg,pdf',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $expense = Expense::findOrFail($id);

        return back()->withToastError('Cannot Update Expense. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $expense = Expense::find($id);

        try {
            $updateNow = $expense->delete();
            return redirect()->back()->withToastSuccess('Expense has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }
    public function getAllexpenses(Request $request)
    {
        $expenses = $this->getForDataTable($request->all());

        return Datatables::of($expenses)
            ->escapeColumns([])
            ->addColumn('expensehead_id', function ($expense) {
                return $expense->expenseHead->name;
            })
            ->addColumn('name', function ($expense) {
                return $expense->name;
            })
            ->addColumn('invoice_number', function ($expense) {
                return $expense->invoice_number;
            })
            ->addColumn('date', function ($expense) {
                return $expense->date;
            })
            ->addColumn('amount', function ($expense) {
                return $expense->amount;
            })
            ->addColumn('description', function ($expense) {
                return $expense->description;
            })
            ->addColumn('document', function ($expense) {
                return $expense->document;
            })
            ->addColumn('created_at', function ($expense) {
                return $expense->created_at->diffForHumans();
            })
            ->addColumn('status', function ($attendanceType) {
                return $attendanceType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($expense) {
                return view('backend.school_admin.expense.partials.controller_action', ['expense' => $expense])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Expense::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
