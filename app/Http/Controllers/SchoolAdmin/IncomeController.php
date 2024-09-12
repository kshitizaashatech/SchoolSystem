<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use App\Models\IncomeHead;
use Validator;
use Carbon\Carbon;
use App\Models\Income;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class IncomeController extends Controller
{
    public function index()
    {
        $page_title = 'Income Listing';
        $incomeshead = IncomeHead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.income.index', compact('page_title', 'incomeshead'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'incomehead_id' => 'required|string',
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
            $incomeData = $request->all();
            $incomeData['school_id'] = Auth::user()->school_id; 
            $savedData = Income::create($incomeData);

            return redirect()->back()->withToastSuccess('Income Saved Successfully!');

        } catch (\Exception $e) {

            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $income = Income::find($id);
        return view('backend.school_admin.income.index', compact('income'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'incomehead_id' => 'required|string',
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

        $income = Income::findOrFail($id);

        return back()->withToastError('Cannot Update Income. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $income = Income::find($id);

        try {
            $updateNow = $income->delete();
            return redirect()->back()->withToastSuccess('Income has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }
    public function getAllIncomes(Request $request)
    {
        $incomes = $this->getForDataTable($request->all());

        return Datatables::of($incomes)
            ->escapeColumns([])
            ->addColumn('incomehead_id', function ($income) {
                return $income->incomeHead->name; //incomeHead is  public function incomeHead(){ } relationship from Income.php Model
            })
            ->addColumn('name', function ($income) {
                return $income->name;
            })
            ->addColumn('invoice_number', function ($income) {
                return $income->invoice_number;
            })
            ->addColumn('date', function ($income) {
                return $income->date;
            })
            ->addColumn('amount', function ($income) {
                return $income->amount;
            })
            ->addColumn('description', function ($income) {
                return $income->description;
            })
            ->addColumn('document', function ($income) {
                return $income->document;
            })
            ->addColumn('created_at', function ($income) {
                return $income->created_at->diffForHumans();
            })
            ->addColumn('status', function ($attendanceType) {
                return $attendanceType->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($income) {
                return view('backend.school_admin.income.partials.controller_action', ['income' => $income])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Income::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
