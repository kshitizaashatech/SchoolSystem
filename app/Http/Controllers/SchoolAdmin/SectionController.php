<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Section;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{

    public function index()
    {
        $page_title = 'Section Listing';
        $sections = Section::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.section.index', compact('page_title', 'sections'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'required',
            'section_name' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            // Get the section name from the request
            $sectionName = $request->input('section_name');

            // Create two sections with modified names
            $section1 = new Section();
            $section1->section_name = $sectionName . '(eng)';
            $section1->is_active = $request->input('is_active');
            $section1->save();

            $section2 = new Section();
            $section2->section_name = $sectionName . '(np)';
            $section2->is_active = $request->input('is_active');
            $section2->save();

            return redirect()->back()->withToastSuccess('Section Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $section = Section::find($id);
        return view('backend.school_admin.section.index', compact('section'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            // 'school_id' => 'required',
            'section_name' => 'required',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $section = Section::findOrFail($id);

        try {
            $data = $request->all();
            // $data['school_id'] = session('school_id');
            $updateNow = $section->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated Section!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update Section. Please try again')->withInput();
    }

    public function destroy(string $id)
    {
        $section = Section::find($id);

        try {
            $updateNow = $section->delete();
            return redirect()->back()->withToastSuccess('Section has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllSections(Request $request)
    {
        $sections = $this->getForDataTable($request->all());

        return Datatables::of($sections)
            ->escapeColumns([])
            ->addColumn('section_name', function ($section) {
                return $section->section_name;
            })
            ->addColumn('created_at', function ($section) {
                return $section->created_at->diffForHumans();
            })
            ->addColumn('status', function ($subject) {
                return $subject->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($section) {
                return view('backend.school_admin.section.partials.controller_action', ['section' => $section])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Section::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
