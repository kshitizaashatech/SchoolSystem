<?php

namespace App\Http\Controllers\Shared;


use App\Models\User;
use App\Models\School;
use App\Models\SchoolGroup;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SchoolGroupController extends Controller
{
    public function index()
    {
        $page_title = "School Groups Listing";
        $schools = [];
        // FOR DISTRICT ADMIN
        // GET THE MUNICIPALITY_ID FROM REQUEST OR GET THE Municipality ID from the "CURRENT" logged in user

        // Get the current user
        $user = Auth::user();
        // $selectedSchools = [];


        // Check if the user's role_id is 3 and user_type_id is 3[ Municipality Admin & Municipality]
        if ($user->role_id == 3 && $user->user_type_id == 3) {
            // Get the municipality_id of the current user
            $currentUserMunicipalityId = $user->municipality_id;

            // Fetch schools based on the municipality_id of the current user
            $schools = School::where('municipality_id', $currentUserMunicipalityId)->get();
            // dd($schools);

            // Fetch selected schools associated with each school group
            // $selectedSchools = SchoolGroup::with('schools')->get()->pluck('schools', 'id');
            // $selectedSchoolsJson = json_encode($selectedSchools);
            // dd($selectedSchoolsJson);

            // Fetch only the IDs of the selected schools associated with each school group
            $selectedSchoolGroups = SchoolGroup::with('schools')->get();
            $selectedSchoolsIds = [];

            foreach ($selectedSchoolGroups as $schoolGroup) {
                $selectedSchoolsIds[$schoolGroup->id] = $schoolGroup->schools->pluck('id')->toArray();
            }

            $selectedSchoolsJson = json_encode($selectedSchoolsIds);
            // dd($selectedSchoolsJson);
        }

        return view('backend.shared.school_groups.index',  compact('page_title', 'schools'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:school_groups,name',
            'head_school' => 'required|exists:schools,id', // Ensure the selected head school exists
            'email' => 'required|email|unique:users,email', // Validate email uniqueness
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        try {
            $school_group = new SchoolGroup();
            $school_group->name = $request->input('name');

            $school_group->save();

            // Attach selected schools to the school group
            $selectedSchools = $request->input('schools', []);
            // dd($selectedSchools);
            School::whereIn('id', $selectedSchools)->update(['group_id' => $school_group->id]);

            // Retrieve the selected head school from the dropdown
            $selectedHeadSchoolId = $request->input('head_school');
            $selectedHeadSchool = School::findOrFail($selectedHeadSchoolId);

            if ($selectedHeadSchool) {
                // School's head_school property to true
                $selectedHeadSchool->update(['head_school' => 1]);

                $user = new User();
                $user->user_type_id = 4;
                $user->role_id = 4;
                $user->school_id = $selectedHeadSchool->id;
                $user->state_id = $selectedHeadSchool->state_id;
                $user->district_id = $selectedHeadSchool->district_id;
                $user->municipality_id = $selectedHeadSchool->municipality_id;
                $user->ward_id = $selectedHeadSchool->ward_id;
                $user->f_name = $selectedHeadSchool->name;
                $user->email = $request->input('email');
                $user->password = Hash::make('password');
                $user->username = strtolower(str_replace(' ', '', $request->input('name')) . '-' . "headschool");
                // $user->phone = $selectedHeadSchool->phone_number;
                $user->local_address = $selectedHeadSchool->address;
                // $user->password = Hash::make('headschooluser@123');
                $user->image = $selectedHeadSchool->logo;
                $user->bank_name = $selectedHeadSchool->bank_name;
                $user->disable_reason = $selectedHeadSchool->disable_reason;
                $user->facebook = $selectedHeadSchool->facebook;
                $user->twitter = $selectedHeadSchool->twitter;
                $user->linkedin = $selectedHeadSchool->linkedin;
                $user->instagram = $selectedHeadSchool->instagram;
                $user->note = $selectedHeadSchool->note;
                $user->disable_at = $selectedHeadSchool->disable_at;
                $user->is_active = $selectedHeadSchool->is_active;


                $user->save();
                $user->assignRole(4);
            }
            return redirect()->back()->withToastSuccess('School Group Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:school_groups,name,' . $id,
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->first())->withInput();
        }

        try {
            $school_group = SchoolGroup::findOrFail($id);

            $data = $request->all();
            $updateNow = $school_group->update($data);

            return redirect()->back()->withToastSuccess('Successfully Updated School Group!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }

        return back()->withToastError('Cannot Update School Group. Please try again')->withInput();
    }



    public function destroy($id)
    {
        $school_group = SchoolGroup::find($id);

        try {
            $updateNow = $school_group->delete();
            return redirect()->back()->withToastSuccess('School Group has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }



    public function assignHeadSchool(Request $request)
    {
        try {
            $headSchoolId = $request->input('head_school');

            // Get the group ID of the selected school
            $school = School::findOrFail($headSchoolId);
            $schoolGroupId = $school->group_id;

            // Reset head_school for all schools in the same group
            School::where('group_id', $schoolGroupId)->update(['head_school' => 0]);

            // Set the selected school as the new head_school
            School::where('id', $headSchoolId)->update(['head_school' => 1]);

            return redirect()->route('admin.school-groups.index')->withToastSuccess('School Head has been Successfully Elected!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($error_message);
        }
    }




    // public function getAllSchoolGroups(Request $request)
    // {
    //     $school_group = $this->getForDataTable($request->all());

    //     return Datatables::of($school_group)
    //         ->escapeColumns([])
    //         ->addColumn('created_at', function ($school_group) {
    //             return $school_group->created_at->diffForHumans();
    //         })
    //         ->addColumn('name', function ($school_group) {
    //             return $school_group->name;
    //         })

    //         ->addColumn('actions', function ($school_group) {
    //             return view('backend.shared.school_groups.partials.controller_action', [
    //                 'school_group' => $school_group

    //             ])->render();
    //         })


    //         ->make(true);
    // }

    public function getAllSchoolGroups(Request $request)
    {
        $school_groups = $this->getForDataTable($request->all());
        // Eager load the 'schools' relationship
        $school_groups->load('schools');

        $school_groups->each(function ($school_group) {
            $head_school = $school_group->schools->first(function ($school) {
                return $school->head_school == 1;
            });

            $school_group->head_school = $head_school ? $head_school->id : null;
            $school_group->head_school_name = $head_school ? $head_school->name : null;
        });

        return Datatables::of($school_groups)
            ->escapeColumns([])
            ->addColumn('created_at', function ($school_group) {
                return $school_group->created_at->diffForHumans();
            })
            ->addColumn('name', function ($school_group) {
                return $school_group->name;
            })

            ->addColumn('actions', function ($school_group) {
                return view('backend.shared.school_groups.partials.controller_action', [
                    'school_group' => $school_group,
                    'associated_schools' => $school_group->schools->pluck('id')->toArray(),
                    'head_school' => $school_group->head_school,
                    'head_school_name' => $school_group->head_school_name,
                ])->render();
            })
            ->make(true);
    }


    /**
     * Get all the required data
     *
     * @return Response
     */
    public function getForDataTable($request)
    {
        $dataTableQuery = SchoolGroup::with('schools')
            ->where(function ($query) use ($request) {
                if (isset($request->id)) {
                    $query->where('id', $request->id);
                }
            })
            ->get();

        // dd($dataTableQuery);
        return $dataTableQuery;
    }
}
