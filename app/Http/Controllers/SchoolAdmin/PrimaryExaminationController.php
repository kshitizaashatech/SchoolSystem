<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Services\FormService;
use App\Http\Controllers\Controller;
use App\Http\Services\StudentUserService;
use App\Models\PrimaryExamination;
use Yajra\Datatables\Datatables;

class PrimaryExaminationController extends Controller
{
    protected $formService;
    protected $studentUserService;
    //
    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "List Primary Examination";

        return view('backend.school_admin.primary_examination.index', compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'filled|numeric',
            'exam' => 'required|string',
            'is_publish' => 'boolean',
            'is_rank_generated' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'required|string',
        ]);

        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $examination = $request->all();
            $examination['session_id'] = session('academic_session_id');
            $examination['school_id'] = session('school_id');
            $savedData = PrimaryExamination::Create($examination);
            return redirect()->back()->withToastSuccess('Primary Examination Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $examination = PrimaryExamination::find($id);

        return view('backend.school_admin.primary_examination.index', compact('examination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'filled|numeric',
            'exam' => 'required|string',
            'is_publish' => 'boolean',
            'is_rank_generated' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'required|string',

        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $examination = PrimaryExamination::findorfail($id);
        try {
            $data = $request->all();
            $data['session_id'] = session('academic_session_id');
            $data['school_id'] = session('school_id');
            $updateNow = $examination->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Primary Examination!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Examination Please try again')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $examination = PrimaryExamination::find($id);
        try {
            $updateNow = $examination->delete();
            return redirect()->back()->withToastSuccess('Primary Examination has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }


    public function getAllPrimaryExaminations(Request $request)
    {
        $examination = $this->getForDataTable($request->all());

        return Datatables::of($examination)
            ->escapeColumns([])
            ->addColumn('exam', function ($examination) {
                return $examination->exam;
            })

            ->addColumn('is_publish', function ($examination) {
                return $examination->is_publish == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('is_rank_generated', function ($examination) {
                return $examination->is_rank_generated == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('description', function ($examination) {
                return $examination->description;
            })
            ->addColumn('created_at', function ($examination) {
                return $examination->created_at->diffForHumans();
            })
            ->addColumn('status', function ($examination) {
                return $examination->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($examination) {
                return view('backend.school_admin.primary_examination.partials.controller_action', ['examination' => $examination])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $schoolId = session('school_id');

        $dataTableQuery = PrimaryExamination::where('school_id', $schoolId)
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->get();

        return $dataTableQuery;
    }
}
