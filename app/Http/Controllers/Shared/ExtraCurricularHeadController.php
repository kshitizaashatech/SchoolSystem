<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ExtraCurricularHead;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ExtraCurricularHeadController extends Controller
{
    public function index()
    {
        $page_title = 'ExtraCurricular Head Listing';
        $extracurricularHeads = ExtraCurricularHead::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.extraCurricularHead.index', compact('page_title', 'extracurricularHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:extra_curricular_heads',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $extracurricularHead = $request->all();
            // $incomeHead['school_id'] = 1;
            $savedData = ExtraCurricularHead::create($extracurricularHead);
            return redirect()->back()->withToastSuccess('ExtraCurricular Head Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $extracurricularHead = ExtraCurricularHead::find($id);
        return view('backend.shared.extracurricularHead.index', compact('extracurricularHead'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|unique:extra_curricular_heads,name,' . $id,
            'description' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $extracurricularHead = ExtraCurricularHead::findOrFail($id);

        try {
            $data = $request->all();
            // $data['school_id'] = 1;
            $updateNow = $extracurricularHead->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated ExtraCurricular Head!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update ExtraCurricular Head. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $extracurricularHead = ExtraCurricularHead::find($id);

        try {
            $updateNow = $extracurricularHead->delete();
            return redirect()->back()->withToastSuccess('ExtraCurricularHead has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllExtraCurricularHead(Request $request)
    {
        $extracurricularHeads = $this->getForDataTable($request->all());

        return Datatables::of($extracurricularHeads)
            ->escapeColumns([])
            ->addColumn('name', function ($extracurricularHead) {
                return $extracurricularHead->name;
            })
            ->addColumn('description', function ($extracurricularHead) {
                return $extracurricularHead->description;
            })
            ->addColumn('created_at', function ($extracurricularHead) {
                return $extracurricularHead->created_at->diffForHumans();
            })
            ->addColumn('status', function ($extracurricularHead) {
                return $extracurricularHead->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($extracurricularHead) {
                return view('backend.shared.extracurricularHead.partials.controller_action', ['extracurricularHead' => $extracurricularHead])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = ExtraCurricularHead::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
