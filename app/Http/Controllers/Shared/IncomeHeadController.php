<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\IncomeHead;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class IncomeHeadController extends Controller
{

    public function index()
    {
        $page_title = 'Income Head Listing';
        $incomeHeads = IncomeHead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.incomehead.index', compact('page_title', 'incomeHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:incomeheads',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $incomeHead = $request->all();
            // $incomeHead['school_id'] = 1;
            $savedData = IncomeHead::create($incomeHead);
            return redirect()->back()->withToastSuccess('Income Head Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $incomeHead = IncomeHead::find($id);
        return view('backend.shared.incomehead.index', compact('incomeHead'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:incomeheads,name,' . $id,
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $incomeHead = IncomeHead::findOrFail($id);

        try {
            $data = $request->all();
            // $data['school_id'] = 1;
            $updateNow = $incomeHead->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Income Head!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Income Head. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $incomeHead = IncomeHead::find($id);

        try {
            $updateNow = $incomeHead->delete();
            return redirect()->back()->withToastSuccess('Income Head has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllIncomehead(Request $request)
    {
        $incomeHeads = $this->getForDataTable($request->all());

        return Datatables::of($incomeHeads)
            ->escapeColumns([])
            ->addColumn('name', function ($incomeHead) {
                return $incomeHead->name;
            })
            ->addColumn('description', function ($incomeHead) {
                return $incomeHead->description;
            })
            ->addColumn('created_at', function ($incomeHead) {
                return $incomeHead->created_at->diffForHumans();
            })
            ->addColumn('status', function ($incomeHead) {
                return $incomeHead->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($incomeHead) {
                return view('backend.shared.incomehead.partials.controller_action', ['incomeHead' => $incomeHead])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = IncomeHead::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
