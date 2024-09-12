<?php

namespace App\Http\Controllers\Shared;



use App\Models\Staff;
use App\Models\Classg;
use App\Models\School;

use App\Models\Student;
use App\Models\User;
use App\Models\District;
use App\Models\Department;
use App\Models\SchoolUser;

use Illuminate\Http\Request;
use App\Models\StudentSession;
use App\Models\AcademicSession;

use App\imports\CombinedImport;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Http\Services\StaffUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    protected $formService;
    protected $staffUserService;
    protected $imageSavePath = '/uploads/staffs/';
    public function __construct(FormService $formService, StaffUserService $staffUserService)
    {
        $this->formService = $formService;
        $this->staffUserService = $staffUserService;
    }

    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }
    public function index()
    {

        $staffs = Staff::latest()->get();
        $page_title = 'Staff List';
        return view('backend.shared.staffs.index', compact('staffs', 'page_title'));
    }

    public function create()
{
    $page_title = 'Staff Create Form';
    $departments = Department::all();
    $roles = Role::whereIn('name', ['Teacher', 'Accountant', 'Librarian', 'Principal', 'Receptionist','Helper'])->get();
    $states = $this->formService->getProvinces();
    $adminStateId = Auth::user()->state_id;
    $adminDistrictId = Auth::user()->district_id;
    $adminMunicipalityId = Auth::user()->municipality_id;

    $schoolId = Auth::user()->school_id; 

    return view('backend.shared.staffs.create', compact(
        'page_title', 'states', 'roles', 'departments',
        'adminStateId', 'adminMunicipalityId', 'adminDistrictId',
        'schoolId'
    ));
}


public function show($id)
{
    
}
    // CREATE STAFF
    protected function saveStaff(array $staffInput)
    {
        try {
            $newStaff = Staff::create($staffInput);
        } catch (\Exception $e) {
            // Handle any specific exception related to staff creation
            throw $e;
        }
    }

    // VALIDATION FOR USERS and STAFFS
    protected function validateUserData(Request $request, $isStaff = false)
    {
        $rules = [

            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            'ward_id' => 'required',
            'local_address' => 'required',
            'permanent_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required',
            'religion' => 'nullable',
            'mobile_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'nullable',
            'emergency_contact_person' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'username' => 'nullable',
            'employee_id' => 'nullable',
            // 'password' => 'required',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'bank_name' => 'nullable',
            'bank_account_no' => 'nullable',
            'bank_branch' => 'nullable',
            'note' => 'nullable',
            'role' => 'nullable',
            // 'marital_status' => 'required',
            'is_active' => 'boolean',

        ];

        // Add conditional validation for Staff
        if ($isStaff) {
            $rules += [
                'marital_status' => 'nullable',
            ];

    }

    return $request->validate($rules);
  }


    protected function saveUserImage($croppedImage)
    {
        try {
            $savePath = public_path($this->imageSavePath);

            if (!File::exists($savePath)) {
                // Create the directory if it doesn't exist
                File::makeDirectory($savePath, 0775, true, true);
            }

            // Generate a unique filename
            $filename = time() . '.' . 'jpg';

            // Save the image with a unique filename
            $image = Image::make($croppedImage);
            $image->encode('jpg')->save($savePath . $filename);

            return $this->imageSavePath . $filename;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    protected function createUser(array $userData)
    {
        $userData['user_type_id'] = 6;
        $userData['school_id'] = 1;

        $result = User::create($userData);
        $result->assignRole((int) $userData['role_id']);
        return $result;
    }

    protected function saveResume(Request $request)
    {
        if ($request->hasFile('resume')) {
            $postPath = time() . '.' . $request->file('resume')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/staffs/resume');
            $request->file('resume')->move($destinationPath, $postPath);
            ;

            return $destinationPath . '/' . $postPath;
        }

        return null;
    }

    // SAVING ENTRY FOR SCHOOL_USER PIVOT TABLE
    protected function createSchoolUserEntry($schoolId, $userId)
    {
        try {
            SchoolUser::create([
                'school_id' => $schoolId,
                'user_id' => $userId,
            ]);
        } catch (\Exception $e) {
            // Handle any specific exception related to SchoolUser creation
            throw $e;
        }
    }
    public function store(Request $request)
    {
        try {
            // Debugging to check the role value
            // dd($request->input('role'));

            // CREATING USER WITH ITS RESPECTIVE VALIDATION FUNCTION
            $userInput = $this->validateUserData($request);

            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                $userInput['image'] = $this->saveUserImage($request->input('inputCroppedPic'));
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['student_photo'] = $destinationPath;
            }

            // Include 'role' in user data
            $userInput['role_id'] = $request->input('role');
            // dd($userInput);

            $staffNumber = $request->input('employee_id') ?? '';
            // Generate username based on first letter of f_name, first letter of l_name, and employee number
            $username = strtolower(substr($userInput['f_name'], 0, 1) . substr($userInput['l_name'], 0, 1) . '-' . $staffNumber);
            // Assign the generated username to the user input
            $userInput['username'] = $username;

            $userInput['password'] = Hash::make('password');

            // STAFF USER CREATED AND ASSIGNED
            $staffUser = $this->createUser($userInput);
            // dd($staffUser);
            // $staffUser->assignRole($userInput['role_id']);

            // CREATING STAFF WITH ITS RESPECTIVE VALIDATION
            $staffInput = $this->validateUserData($request, true);
            $staffInput['user_id'] = $staffUser->id;
            $staffInput['school_id'] = session('school_id');


            // $staffInput['employee_id'] = 1;
            $staffInput['department_id'] = $request->input('department_id');
            $staffInput['class_id'] = $request->input('class_id');
            $staffInput['qualification'] = $request->input('qualification');
            $staffInput['work_experience'] = $request->input('work_experience');
            $staffInput['date_of_joining'] = $request->input('date_of_joining');
            $staffInput['date_of_leaving'] = $request->input('date_of_leaving');
            $staffInput['payscale'] = $request->input('payscale');
            $staffInput['basic_salary'] = $request->input('basic_salary');
            $staffInput['contract_type'] = $request->input('contract_type');
            $staffInput['shift'] = $request->input('shift');
            $staffInput['resignation_letter'] = $request->input('resignation_letter');
            $staffInput['joining_letter'] = $request->input('joining_letter');
            $staffInput['medical_leave'] = $request->input('medical_leave');
            $staffInput['casual_leave'] = $request->input('casual_leave');
            $staffInput['maternity_leave'] = $request->input('maternity_leave');
            $staffInput['role'] = $request->input('role');
            // $staffInput['location'] = $request->input('location');
            $staffInput['other_document'] = $request->input('other_document');

            $resumePath = $this->saveResume($request);

            if (!is_null($resumePath)) {
                $staffInput['resume'] = $resumePath;
            }

            $staffInput['staff_photo'] = $staffUser->image;

            // Include 'role' in staff data
            $staffInput['role'] = $request->input('role');

            // Ensure 'role' is set to 'role_id'
            $staffInput['role_id'] = $request->input('role');
            $this->saveStaff($staffInput);

            // Create entry in the SchoolUser pivot table
            $this->createSchoolUserEntry($staffInput['school_id'], $staffUser->id);

            return redirect()->route('admin.staffs.index')->withToastSuccess('Staff successfully created');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        try {
            $staff = Staff::findOrFail($id);
            $states = $this->formService->getProvinces();
            $roles = Role::whereIn('name', ['Teacher', 'Accountant', 'Librarian', 'Principal', 'Receptionist'])->get();
            $selectedRole = $staff->role_id;
            $departments = Department::all();
            $page_title = 'Staff Edit Form';
            // FETCHING DISTRICT FOR SELECTED STATE
            $districts = $staff->user->district_bystate($staff->user->state_id);
            // FETCHING MUNICIPALITY FOR SELECTED DISTRICT
            $municipalities = $staff->user->municipalities_bydistrict($staff->user->district_id);

            // FETCHING WARDS BY MUNICIAITY
            $wards = User::getWards($staff->user->municipality_id);


            return view('backend.shared.staffs.update', compact('staff', 'page_title', 'states', 'roles', 'selectedRole', 'districts', 'municipalities', 'wards', 'departments'));
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedUserData = $this->validateUserData($request);
            $validatedStaffData = $this->validateUserData($request, true);
            $staff = Staff::findOrFail($id);
    
            DB::beginTransaction();
    
            if ($staff->user) {
                if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                    $userInput['image'] = $this->saveUserImage($request->input('inputCroppedPic'));
                }
                $staff->user->update($validatedUserData);
                if ($request->has('role_id')) {
                    $staff->user->update(['role_id' => $request->role_id]);
                    $staff->user->syncRoles([(int) $request->role_id]);
                }
            }

            $staff->update($validatedStaffData);
            if ($request->has('role')) {
                $staff->update(['role' => $request->role]);
                if ($staff->user) {
                    $staff->user->update(['role_id' => $request->role]);
                }
            }
    
            DB::commit();
    
            return redirect()->route('admin.staffs.index')->withToastSuccess('Staff successfully Updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $staff = Staff::with('user')->findOrFail($id);

        if ($staff->delete()) {
            return redirect()->back()->withToastSuccess('Staff Successfully Deleted!');
        } else {
            return back()->withToastError('An error occurred while performing the operation.');
        }
    }


    public function getAllStaff(Request $request)
    {
        $staff = $this->staffUserService->getStaffsForDataTable($request->all());
        // dd($staff);
        return Datatables::of($staff)
            ->editColumn('f_name', function ($row) {
                return $row->f_name;
            })
            ->editColumn('l_name', function ($row) {
                return $row->l_name;
            })
            ->editColumn('marital_status', function ($row) {
                return $row->marital_status ; 
            })
            ->editColumn('date_of_joining', function ($row) {
                return $row->date_of_joining;
            })
            ->editColumn('date_of_leaving', function ($row) {
                return $row->date_of_leaving;
            })
            ->editColumn('contract_type', function ($row) {
                return $row->contract_type;
            })
            ->editColumn('shift', function ($row) {
                return $row->shift;
            })
            ->editColumn('maternity_leave', function ($row) {
                return $row->maternity_leave;
            })
            ->editColumn('other_document', function ($row) {
                return $row->other_document;
            })

            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })

            ->addColumn('status', function ($staff) {
                return $staff->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($staff) {
                return view('backend.shared.staffs.partials.controller_action', [
                    'staff' => $staff
                ])->render();
            })

            ->make(true);
    }

    public function importStaffs()
    {
        $page_title = "Import Staff";
        $schoolId = session('school_id');
        return view('backend.shared.staffs.importindex', compact('page_title'));
    }

    public function addLeaveDetails(Request $request)
    {
        $leave = 'Add Leave Details';
        $type = $request->query('type');
        $staffId = $request->query('staff_id');
        
        return view('backend.shared.staffs.leavedetails', compact('leave', 'type', 'staffId'));
    }

    public function storeLeaveDetails(Request $request)
    {
        $validatedData = $request->validate([
            'medical_leave' => 'required|string',
            'casual_leave' => 'required|string',
            'staff_id' => 'required|exists:staffs,id',
        ]);

        // Find the staff member by ID
        $staff = Staff::findOrFail($validatedData['staff_id']);

        // Update the staff member's leave details
        $staff->medical_leave = $validatedData['medical_leave'];
        $staff->casual_leave = $validatedData['casual_leave'];
        $staff->save();

        return redirect()->route('admin.staffs.index')->with('success', 'Leave details added successfully.');
    }

    public function addResignationDetails(Request $request)
    {
        $page_title = 'Add Resignation Details';
        $type= $request->query('type');
        $staffId= $request->query('staff_id');
        return view('backend.shared.staffs.resignationdetails', compact('page_title','type','staffId'));
    }

    public function storeResignationDetails(Request $request)
    {
        $validatedData = $request->validate([
            'resignation_letter' => 'required|string',
            'staff_id' => 'required|exists:staffs,id',
            //'note' => 'nullable|string',
        ]);
        $staff = Staff::findOrFail($validatedData['staff_id']);
        $staff->resignation_letter = $validatedData['resignation_letter'];
        //$staff->note = $validatedData['note'];
        $staff->save();
        return redirect()->route('admin.staffs.index')->with('success', 'Staff resignation added successfully.');
    }

    public function import(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            $array1 = Excel::toCollection(new CombinedImport, $request->file('file'));
    
            // Access the outer collection
            foreach ($array1 as $outerCollection) {
                // Iterate through the inner collections
                foreach ($outerCollection as $row) {
    
                    $data = $row->toArray();
    
                    // Ensure 'marital_status' key exists and standardize its value
                    if (!array_key_exists('marital_status', $data)) {
                        $data['marital_status'] = null;
                    } else {
                        $data['marital_status'] = trim(strtolower($data['marital_status']));
                    }
    
                    $validator = Validator::make($data, [
                        'state_id' => 'required',
                        'district_id' => 'required',
                        'municipality_id' => 'required',
                        'ward_id' => 'required',
                        'f_name' => 'required',
                        'l_name' => 'required',
                        'mobile_number' => 'required',
                        'email' => 'required|unique:users,email',
                        'employee_id' => 'required|unique:staffs,employee_id',
                        'gender' => 'required',
                        'role' => 'required',
                        'dob' => 'required',
                        'department' => 'required',
                        'contract_type' => 'required',
                        'emergency_contact_person' => 'required',
                        'emergency_contact_phone' => 'required',
                        'marital_status' => 'nullable', // Allow marital_status to be nullable
                    ]);
    
                    if ($validator->fails()) {
                        // Redirect back with validation errors
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
    
                    // Extract role id from name
                    $role_id = $this->roleIdentification($data['role']);
                    if ($role_id == null) {
                        return redirect()->back()->withErrors('Invalid Role name of : ' . $data['f_name'])->withInput();
                    }
    
                    // Extract department id from name
                    $department_id = $this->departmentIdentification($data['department']);
                    if ($department_id == null) {
                        return redirect()->back()->withErrors('Invalid Department name of : ' . $data['f_name'])->withInput();
                    }
    
                    $marriedId = $this->maritialStatus($data['marital_status']);
                    if ($marriedId === null && $data['marital_status'] !== null) {
                        return redirect()->back()->withErrors('Invalid Marital Status of : ' . $data['f_name'])->withInput();
                    }
    
                    $staffUser = User::create([
                        'user_type_id' => 6,
                        'role_id' => $role_id,
                        'school_id' => session('school_id'),
                        'state_id' => $data['state_id'],
                        'district_id' => $data['district_id'],
                        'municipality_id' => $data['municipality_id'],
                        'ward_id' => $data['ward_id'],
                        'f_name' => $data['f_name'],
                        'm_name' => $data['m_name'] ?? null,
                        'l_name' => $data['l_name'],
                        'email' => $data['email'],
                        'local_address' => $data['local_address'] ?? null,
                        'permanent_address' => $data['permanent_address'] ?? null,
                        'password' => bcrypt('password'),
                        'gender' => $data['gender'],
                        'religion' => $data['religion'] ?? null,
                        'dob' => $data['dob'] ?? null,
                        'blood_group' => $data['blood_group'] ?? null,
                        'father_name' => $data['father_name'] ?? null,
                        'father_phone' => $data['father_phone'] ?? null,
                        'mother_name' => $data['mother_name'] ?? null,
                        'mother_phone' => $data['mother_phone'] ?? null,
                        'emergency_contact_person' => $data['emergency_contact_person'],
                        'emergency_contact_phone' => $data['emergency_contact_phone'],
                    ]);
    
                    // CREATE staff
                    $studentCreate = Staff::create([
                        'user_id' => $staffUser->id,
                        'school_id' => session('school_id'),
                        'employee_id' => $data['employee_id'],
                        'department_id' => $department_id,
                        'qualification' => $data['qualification'] ?? null,
                        'work_experience' => $data['work_experience'] ?? null,
                        'marital_status' => $marriedId,
                        'date_of_joining' => $data['date_of_joining'] ?? null,
                        'payscale' => $data['payscale'] ?? null,
                        'basic_salary' => $data['basic_salary'] ?? null,
                        'contract_type' => $data['contract_type'],
                        'shift' => $data['shift'],
                        'medical_leave' => $data['medical_leave'] ?? null,
                        'casual_leave' => $data['casual_leave'] ?? null,
                        'maternity_leave' => $data['maternity_leave'] ?? null,
                        'role' => $role_id,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Data has been uploaded');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    

    public function roleIdentification($role_name)
    {
        $roleId = null;
        switch ($role_name) {
            case "Teacher":
                $roleId = 6;
                break;
            case "Accountant":
                $roleId = 7;
                break;
            case "Librarian":
                $roleId = 8;
                break;
            case "Principal":
                $roleId = 9;
                break;
            case "Receptionist":
                $roleId = 10;
                break;
            default:
                $roleId = null;
        }

        return $roleId;
    }
    public function departmentIdentification($department_name)
    {
        $departmentId = null;
        switch ($department_name) {
            case "Academic":
                $departmentId = 1;
                break;
            case "Library":
                $departmentId = 2;
                break;
            case "Sports":
                $departmentId = 3;
                break;
            case "Science":
                $departmentId = 4;
                break;
            case "Commerce":
                $departmentId = 5;
                break;
            case "Arts":
                $departmentId = 6;
                break;
            case "Exam":
                $departmentId = 7;
                break;
            case "Admin":
                $departmentId = 8;
                break;
            case "Finance":
                $departmentId = 9;
                break;
            default:
                $departmentId = null;
        }

        return $departmentId;
    }
    public function maritialStatus($status)
    {
        // Trim whitespace and convert to lowercase for standardization
        $status = trim(strtolower($status));
    
        // Define possible statuses in an associative array
        $statuses = [
            'married' => 1,
            'unmarried' => 0,
            'divorced' => 2,
            'widow' => 3,
            'separated' => 4,  // Corrected spelling from 'separeted'
        ];
    
        // Check if the status exists in the array and return the corresponding value
        $maritalStatus = $statuses[$status] ?? null;
    
        echo $status; // Debugging: print the standardized status
        echo ($maritalStatus); // Debugging: print the marital status id
    
        return $maritalStatus;
    }
    


}

