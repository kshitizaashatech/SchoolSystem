<?php

namespace App\Http\Controllers\Shared;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AcademicSessionController extends Controller
{

    public function index()
    {
        $page_title = 'Academic Session Listing';
        $academicsession = AcademicSession::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.shared.academicsession.index', compact('page_title', 'academicsession'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'session' => 'required|string|unique:academic_sessions',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $academicsession = $request->all();
            $savedData = AcademicSession::Create($academicsession);
            return redirect()->back()->withToastSuccess('Academic Session Saved Successfully!');

        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $academicsession = AcademicSession::find($id);

        return view('backend.shared.academicsession.index', compact('academicsession'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'session' => 'required|string|unique:academic_sessions,session,' . $id,
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $academicsession = AcademicSession::findorfail($id);
        try {
            $data = $request->all();
            $updateNow = $academicsession->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Academic Session!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Academic Session Please try again')->withInput();
    }
    public function destroy(string $id)
    {
        $academicsession = AcademicSession::find($id);
        try {
            $updateNow = $academicsession->delete();
            return redirect()->back()->withToastSuccess('Academic Session has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }
    public function getAllAcademicsession(Request $request)
    {
        $academicsession = $this->getForDataTable($request->all());

        return Datatables::of($academicsession)
            ->escapeColumns([])
            ->addColumn('name', function ($academicsession) {
                return $academicsession->session;
            })
            ->addColumn('from', function ($academicsession) {
                return $academicsession->from_date;
            })
            ->addColumn('to', function ($academicsession) {
                return $academicsession->to_date;
            })
            ->addColumn('created_at', function ($academicsession) {
                return $academicsession->created_at->diffForHumans();
            })
            ->addColumn('status', function ($academicsession) {
                return $academicsession->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';

            })

            ->addColumn('actions', function ($academicsession) {
                return view('backend.shared.academicsession.partials.controller_action', ['academicsession' => $academicsession])->render();
            })

            ->make(true);
    }
    public function getForDataTable($request)
    {
        $dataTableQuery = AcademicSession::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}