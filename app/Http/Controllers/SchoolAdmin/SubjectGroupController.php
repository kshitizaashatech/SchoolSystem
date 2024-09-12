<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use App\Models\School;
use Validator;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\Subject;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Rules\UniqueSubjectGroup;

class SubjectGroupController extends Controller
{
    public function index()
    {
        $page_title = 'Subject Group Listing';
        $schoolId = session('school_id');
        $subjectgroup = Subject::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        // $subjectgroup = Subject::orderBy('created_at', 'desc')->get();
        // $classess = Classg::orderBy('created_at', 'desc')->get();
        // Fetch classes based on the school ID
        $classess = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $results = $this->getSubjectGroups();
        return view('backend.school_admin.subject_group.index', compact('page_title', 'subjectgroup', 'classess', 'results'));
    }



    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'subject_group_name' => 'required|unique:subject_groups',
            'class_id' => 'required|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'is_active' => 'required',
            'subject_group' => 'required|array',
            'subject_group.*' => 'exists:subjects,id',
            'subject_group' => [new UniqueSubjectGroup($request->input('class_id'), $request->input('sections'), $request->input('subject_group'))],

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }
        // $validatedData = $request->validate([
        //     'subject_group_name' => 'required',
        //     'class_id' => 'required|exists:classes,id',
        //     'sections' => 'required|array',
        //     'sections.*' => 'exists:sections,id',
        //     'is_active' => 'required',
        //     'subject_group' => 'required|array',
        //     'subject_group.*' => 'exists:subjects,id',
        //     'subject_group' => [new UniqueSubjectGroup($request->input('class_id'), $request->input('sections'), $request->input('subject_group'))],
        // ]);
        // $validatedData = $request->validate([
        //     'subject_group_name' => 'required',
        //     'class_id' => 'required|exists:classes,id',
        //     'sections' => 'required|array',
        //     'sections.*' => 'exists:sections,id',
        //     'is_active' => 'required',
        //     'subject_group' => 'required|array',
        //     'subject_group.*' => 'exists:subjects,id',
        // ]);


        try {

            $subjectGroup = SubjectGroup::create([
                'school_id' => session('school_id'),
                'subject_group_name' => $request->input('subject_group_name'),
                'is_active' => $request->input('is_active'),
            ]);
            $subjectGroup->classes()->sync($request->input('class_id'));
            $subjectGroup->sections()->sync($request->input('sections'));
            $subjectGroup->subjects()->sync($request->input('subject_group'));

            return redirect()->back()->withToastSuccess('SubjectGroup Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'subject_group_name' => 'required|unique:subject_groups,subject_group_name,' . $id,
            'class_id' => 'required|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'is_active' => 'required',
            'subject_group' => 'required|array',
            'subject_group.*' => 'exists:subjects,id',
            'subject_group' => [new UniqueSubjectGroup($request->input('class_id'), $request->input('sections'), $request->input('subject_group'), $id)],

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $validatedData = $request->validate([
            'subject_group_name' => 'required',
            'class_id' => 'required|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'is_active' => 'required',
            'subject_group' => 'required|array',
            'subject_group.*' => 'exists:subjects,id',
        ]);

        try {
            // Find the subject group by ID
            $subjectGroup = SubjectGroup::findOrFail($id);

            // Update the subject group attributes
            $subjectGroup->update([
                'school_id' => session('school_id'),
                'subject_group_name' => $request->input('subject_group_name'),
                'is_active' => $request->input('is_active'),
            ]);
            $subjectGroup->classes()->sync($request->input('class_id'));
            $subjectGroup->sections()->sync($request->input('sections'));
            $subjectGroup->subjects()->sync($request->input('subject_group'));

            return redirect()->back()->withToastSuccess('SubjectGroup Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        $subjectgroup = SubjectGroup::find($id);

        try {
            $updateNow = $subjectgroup->delete();
            return redirect()->back()->withToastSuccess('SubjectGroup has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getSubjectGroups()
    {
        $schoolId = session('school_id');

        $schoolId = session('school_id');

        $subjectGroups = SubjectGroup::with('subjects')
            ->whereHas('classes', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->whereHas('sections', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->get();

        // Manipulate the data as needed
        return $subjectGroups->map(function ($subjectGroup) {
            return [
                'id' => $subjectGroup->id,
                'subject_group_name' => $subjectGroup->subject_group_name,
                'is_active' => $subjectGroup->is_active,
                'created_at' => $subjectGroup->created_at->diffForHumans(),
                'classes' => $subjectGroup->classes,
                'sections' => $subjectGroup->sections,
                'subjects' => $subjectGroup->subjects
            ];
        });


        // $subjectGroups = SubjectGroup::with('subjects')->get();
        // // Manipulate the data as needed
        // return $subjectGroups->map(function ($subjectGroup) {
        //     return [
        //         'id' => $subjectGroup->id,
        //         'subject_group_name' => $subjectGroup->subject_group_name,
        //         'is_active' => $subjectGroup->is_active,
        //         'created_at' => $subjectGroup->created_at->diffForHumans(),
        //         'classes' => $subjectGroup->classes,
        //         'sections' => $subjectGroup->sections,
        //         'subjects' => $subjectGroup->subjects
        //     ];
        // });
    }
}
