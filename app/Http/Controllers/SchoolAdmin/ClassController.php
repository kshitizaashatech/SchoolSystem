<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\Section;
use App\Models\ClassSection;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    public function index()
    {
        $page_title = 'Class Listing';
        // $classmgt = Classg::orderBy('created_at', 'desc')->paginate(10);
        // $classmgts = Classg::with('sections')->get();
        $sectionmgt = Section::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.class.index', compact('page_title', 'sectionmgt'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'class' => 'required|',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $classmgt = $request->all();
            $classmgt['school_id'] = session('school_id');
            $savedData = Classg::Create($classmgt);

            // Retrieve the inserted class ID
            $classId = $savedData->id;

            // Insert each section individually
            $sections = $request->input('sections');

            foreach ($sections as $sectionId) {
                ClassSection::create([
                    'school_id' => session('school_id'),
                    'class_id' => $classId,
                    'section_id' => $sectionId,
                ]);
            }


            // Sync the associated sections
            // $subjectGroup->sections()->sync($request->input('sections'));

            return redirect()->back()->withToastSuccess('Class Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $classmgt = Classg::find($id);
        $selectedSections = $classmgt->sections->pluck('id')->toArray();

        return view('backend.school_admin.class.index', compact('classmgt', 'selectedSections'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'school_id' => 'filled|numeric',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'class' => 'required',
            'is_active' => 'required',
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $classmgt = Classg::findorfail($id);
        try {
            $data = $request->all();
            $data['school_id'] = session('school_id');
            $updateNow = $classmgt->update($data);

            // Detach existing sections
            $classmgt->sections()->detach();

            // Attach the updated sections
            $sections = $request->input('sections');
            foreach ($sections as $sectionId) {
                ClassSection::create([
                    'school_id' => session('school_id'),
                    'class_id' => $classmgt->id,
                    'section_id' => $sectionId,
                ]);
            }

            // Sync the associated sections
            // $updateNow->sections()->sync($request->input('sections'));

            return redirect()->back()->withToastSuccess('Successfully Updated Class!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Class Please try again')->withInput();
    }
    public function destroy(string $id)
    {
        $classmgt = Classg::find($id);
        try {
            $updateNow = $classmgt->delete();
            return redirect()->back()->withToastSuccess('Class has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }
    public function getAllClasses(Request $request)
    {
        $classmgts = $this->getForDataTable($request->all());

        return Datatables::of($classmgts)
            ->escapeColumns([])
            // ->addColumn('school_id', function ($classmgt) {
            //     return $classmgt->school_id;
            // })
            ->addColumn('id', function ($classmgt) {
                return $classmgt->id;
            })
            ->addColumn('class', function ($classmgt) {
                return $classmgt->class;
            })
            ->addColumn('sections', function ($classmgt) {
                return implode(', ', $classmgt->sections->pluck('section_name')->toArray());
                // return $classmgt->sections->pluck('section_name')->implode(', ');
            })
            ->addColumn('created_at', function ($classmgt) {
                return $classmgt->created_at->diffForHumans();
            })
            ->addColumn('status', function ($classmgt) {
                return $classmgt->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($classmgt) {
                return view('backend.school_admin.class.partials.controller_action', ['classmgt' => $classmgt])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $schoolId = session('school_id');

        $dataTableQuery = Classg::where('school_id', $schoolId)
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->get();

        return $dataTableQuery;
    }
}