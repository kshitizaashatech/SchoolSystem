<?php

namespace App\Http\Controllers\SchoolAdmin;

// use Validator;
use Image, View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\SchoolUser;
use App\Models\SchoolHouse;
use Illuminate\Http\Request;
use App\Models\BloodGroupType;
use App\Models\StudentSession;
use App\imports\CombinedImport;
use App\Models\AcademicSession;
use App\Models\StudentAttendance;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\StudentUserService;
use App\Models\Municipality;
use Illuminate\Support\Facades\Validator;

use App\Exports\StudentsExport;


class StudentController extends Controller
{
    protected $formService;
    protected $studentUserService;

    protected $imageSavePath = '/uploads/students/profile_images';

    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }

    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }

    public function index()
    {
        $page_title = 'Student List';
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

         // Retrieve only students whose associated users are active
         $students = Student::whereHas('user', function ($query) {
            $query->where('is_active', 1); // Ensure '1' matches the active status
        })->where('school_id', $schoolId)->latest()->get();

        return view('backend.school_admin.student.index', compact('students', 'page_title', 'classes'));
    }

    public function create()
    {
        $page_title = 'Create Student';
        $states = $this->formService->getProvinces();
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $school_houses = SchoolHouse::all();
        $bloodGroups = BloodGroupType::pluck('type', 'id');
        // $bloodGroups = BloodGroupType::all();
        // dd($bloodGroups);

        $adminStateId = Auth::user()->state_id;
        $adminDistrictId = Auth::user()->district_id;
        $adminMunicipalityId = Auth::user()->municipality_id;
        $adminSchoolId = Auth::user()->school_id;

        return view(
            'backend.school_admin.student.create',
            compact(
                'page_title',
                'states',
                'classes',
                'school_houses',
                'adminStateId',
                'adminDistrictId',
                'adminMunicipalityId',
                'adminSchoolId',
                'bloodGroups'
            )
        );
    }

    public function additionalInformationStudents($student_id, Request $request)
    {
        // dd($request);
        $page_title = 'Create Additional Student Information';
        $student = Student::findOrFail($student_id);
        // You can pass $student to your view for use in the form
        return view('backend.school_admin.student.additional_information_create', compact('student', 'page_title'));
    }

    public function updateAdditionalInformation(Request $request, $student_id)
    {
        try {
            // Find the student's associated user
            $user = Student::findOrFail($student_id)->user;

            // Validate the submitted data
            $validatedData = $request->validate([
                'bank_name' => 'required',
                'bank_account_no' => 'nullable',
                'bank_branch' => 'nullable',
                'username' => 'nullable',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'linkedin' => 'nullable',
                'instagram' => 'nullable',
            ]);

            // Update the user's additional information
            $user->update($validatedData);

            return redirect()->back()->withToastSuccess('Additional information updated successfully');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }







    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    public function getSections($classId)
    {
        $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');
        return response()->json($sections);
    }

    // CREATE STUDENT
    protected function saveStudent(array $studentInput)
    {
        try {
            $newStudent = Student::create($studentInput);
        } catch (\Exception $e) {
            // Handle any specific exception related to student creation
            throw $e;
        }
    }

    // SAVING IMAGE FOR USER
    protected function saveUserImage($croppedImage)
    {
        if (!File::exists($this->imageSavePath)) {
            File::makeDirectory($this->imageSavePath, 0775, true, true);
        }

        $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
        Image::make($croppedImage)
            ->encode('jpg')
            ->save(public_path($destinationPath));

        return $destinationPath;
    }

    protected function createUser(array $userData)
    {
        $userData['user_type_id'] = 8;  //students
        $userData['role_id'] = 11;  // student
        $userData['school_id'] = session('school_id');

        return User::create($userData);
    }


    protected function saveTransferCertificate(Request $request)
    {
        if ($request->hasFile('transfer_certificate')) {
            $postPath = time() . '.' . $request->file('transfer_certificate')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/students/certificates');
            $request->file('transfer_certificate')->move($destinationPath, $postPath);;

            return $destinationPath . '/' . $postPath;
        }

        return null; // Return null only if no file is present
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

    // VALIDATION FOR USERS
    protected function validateUserData(Request $request, $isStudent = false)
    {
        $rules = [
            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            'ward_id' => 'required',
            'local_address' => 'nullable',
            'permanent_address' => 'nullable',
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'religion' => 'nullable',
            'mobile_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'nullable',
            // 'image' => 'required',
            'father_name' => 'nullable',
            'father_phone' => 'nullable',
            'father_occupation' => 'nullable',
            'mother_name' => 'nullable',
            'mother_phone' => 'nullable',
            'mother_occupation' => 'nullable',
            'emergency_contact_person' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'username' => 'nullable',
            // 'password' => 'required',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'bank_name' => 'nullable',
            'bank_account_no' => 'nullable',
            'bank_branch' => 'nullable',
            'note' => 'nullable',
            'is_active' => 'boolean',
            'guardian_is' => 'nullable',
        ];

        // Add conditional validation for guardian-related fields in student data
        if ($isStudent && $request->input('guardian_is') == 'other') {
            $rules += [
                'guardian_name' => 'nullable',
                'guardian_relation' => 'nullable',
                'guardian_phone' => 'nullable',
            ];
        }

        return $request->validate($rules);
    }


    // CREATING STUDENT SESSION
    private function createStudentSession($userId, $classId, $sectionId)
    {
        $latestAcademicSession = AcademicSession::latest()->first();
        if ($latestAcademicSession) {
            StudentSession::create([
                'user_id' => $userId,
                'academic_session_id' => $latestAcademicSession->id,
                'school_id' => session('school_id'),
                'class_id' => $classId,
                'section_id' => $sectionId,
                'is_active' => true,
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            // CREATING USER WITH ITS RESPECTIVE VALIDATION FUNCTION
            $userInput = $this->validateUserData($request, true);
    
            // Generate username based on first letter of f_name, first letter of l_name, and admission number
            $admissionNumber = $request->input('admission_no') ?? '';
            $username = strtolower(substr($userInput['f_name'], 0, 1) . substr($userInput['l_name'], 0, 1) . '-' . $admissionNumber);
            $userInput['username'] = $username;
    
            // Generate email dynamically if not provided
            if (!$request->filled('email')) {
                $email = strtolower($userInput['f_name'] . '.' . $userInput['l_name'] . '.' . $admissionNumber . '@gmail.com');
                $count = User::where('email', $email)->count();
                if ($count > 0) {
                    // If the email already exists, append a number to make it unique
                    $email = strtolower($userInput['f_name'] . '.' . $userInput['l_name'] . '.' . $admissionNumber . $count . '@gmail.com');
                }
                $userInput['email'] = $email;
            } else {
                $userInput['email'] = $request->input('email');
            }
    
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                $userInput['image'] = $this->saveUserImage($request->input('inputCroppedPic'));
            }
    
            // STUDENT USER CREATED AND ASSIGNED
            $studentUser = $this->createUser($userInput);
            $studentUser->assignRole(11);
    
            // Create student_sessions record
            $this->createStudentSession($studentUser->id, $request->input('class_id'), $request->input('section_id'));
    
            // CREATING STUDENT WITH ITS RESPECTIVE VALIDATION
            $studentInput = $userInput;
            $studentInput['user_id'] = $studentUser->id;
            $studentInput['school_id'] = session('school_id');
            $studentInput['reservation_quota_id'] = $request->input('reservation_quota_id') ?? "";
            $studentInput['class_id'] = $request->input('class_id') ?? "";
            $studentInput['section_id'] = $request->input('section_id') ?? "";
            $studentInput['admission_no'] = $request->input('admission_no') ?? "";
            $studentInput['admission_date'] = $request->input('admission_date') ?? "";
            $studentInput['roll_no'] = $request->input('roll_no') ?? "";
            $studentInput['school_house_id'] = $request->input('school_house_id');
            $studentInput['student_photo'] = $studentUser->image;
            $studentInput['guardian_name'] = $request->input('guardian_name') ?? "";
            $studentInput['guardian_relation'] = $request->input('guardian_relation') ?? "";
            $studentInput['guardian_phone'] = $request->input('guardian_phone') ?? "";
            $studentInput['guardian_email'] = $request->input('guardian_email') ?? "";
    
            // Add transfer_certificate if a file is present
            $transferCertificatePath = $this->saveTransferCertificate($request);
            if (!is_null($transferCertificatePath)) {
                $studentInput['transfer_certificate'] = $transferCertificatePath;
            }
    
            $this->saveStudent($studentInput);
    
            // Create entry in the SchoolUser pivot table
            $this->createSchoolUserEntry($studentInput['school_id'], $studentUser->id);
    
            DB::commit();
    
            return redirect()->route('admin.students.index')->withToastSuccess('Student successfully created');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withToastError($e->getMessage())->withInput();
        }
    }
    

    public function show(Request $request)
    {
    }

    public function edit(string $id)
{
    try {
        $student = Student::findOrFail($id);
        $page_title = "Edit Student";

        // Fetching necessary data for the form
        $states = $this->formService->getProvinces();
        $schoolId = session('school_id');

        // Fetching classes for the school
        $classes = Classg::where('school_id', $schoolId) 
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetching school houses
        $school_houses = SchoolHouse::all();

        // Fetching blood groups
        $bloodGroups = BloodGroupType::pluck('type', 'id');

        // Fetching sections for the first class
        $firstClassId = $classes->first()->id ?? null;
        $sections = $firstClassId ? $this->getSections($firstClassId)->original : [];

        // Fetching districts for selected state
        $districts = $student->user->district_bystate($student->user->state_id);

        // Fetching municipalities for selected district
        $municipalities = $student->user->municipalities_bydistrict($student->user->district_id);

        // Fetching wards by municipality
        $wards = User::getWards($student->user->municipality_id);
        


        return view('backend.school_admin.student.update', compact('student', 'page_title', 'states', 'classes', 'school_houses', 'sections', 'districts', 'municipalities', 'wards', 'bloodGroups'));
    } catch (\Exception $e) {
        return back()->withToastError($e->getMessage());
    }
}

    public function update(Request $request, $id)
    {
        try {

            // $validatedData = Validator::make($request->all(), [
            $validatedData = $request->validate([
                'state_id' => 'required',
                'district_id' => 'required',
                'municipality_id' => 'required',
                'ward_id' => 'required',
                'local_address' => 'nullable',
                'permanent_address' => 'nullable',
                'f_name' => 'required',
                'l_name' => 'required',
                'email' => 'required',
                'religion' => 'nullable',
                'mobile_number' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'blood_group' => 'nullable',
                // 'image' => 'required',
                'father_name' => 'nullable',
                'father_phone' => 'nullable',
                'father_occupation' => 'nullable',
                'mother_name' => 'nullable',
                'mother_phone' => 'nullable',
                'mother_occupation' => 'nullable',
                'emergency_contact_person' => 'required',
                'emergency_contact_phone' => 'required',
                'username' => 'nullable',
                // 'password' => 'required',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'linkedin' => 'nullable',
                'instagram' => 'nullable',
                'bank_name' => 'nullable',
                'bank_account_no' => 'nullable',
                'bank_branch' => 'nullable',
                'note' => 'nullable',
                'is_active' => 'boolean',
                'guardian_is' => 'nullable',

                'admission_no' => 'nullable',
                'roll_no' => 'nullable',
                'admission_date' => 'nullable',
                'reservation_quota_id' => 'nullable',
                'class_id' => 'nullable',
                'section_id' => 'nullable',
                'school_house_id' => 'nullable',
                'guardian_name' => 'nullable',
                'guardian_relation' => 'nullable',
                'guardian_phone' => 'nullable',
                'guardian_email' => 'nullable'
            ]);
            // Validate user and student data
            // $validatedUserData = $this->validateUserData($request);
            // $validatedStudentData = $this->validateUserData($request, true);

          // Retrieve the student by ID
        $student = Student::findOrFail($id);

        // Check if the user already exists for the student
        if ($student->user) {
            // Update existing user data
            $userInput = $validatedData;

            // Add conditional fields based on guardian_is value
            if ($request->input('guardian_is') == 'other') {
                $userInput['guardian_name'] = $request->input('guardian_name');
                $userInput['guardian_relation'] = $request->input('guardian_relation');
                $userInput['guardian_phone'] = $request->input('guardian_phone');
            }

            // Check if a new photo is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                $userInput['image'] = $this->saveUserImage($request->input('inputCroppedPic'));
            }

            // Update the existing user
            $student->user->update($userInput);
        }

        // Update the student data
        $student->update($validatedData);

        // Manually assign additional fields if they are not in the validated data
        $student->admission_no = $request->input('admission_no') ?? $student->admission_no;
        $student->roll_no = $request->input('roll_no') ?? $student->roll_no;
        $student->admission_date = $request->input('admission_date') ?? $student->admission_date;
        $student->reservation_quota_id = $request->input('reservation_quota_id') ?? $student->reservation_quota_id;
        $student->class_id = $request->input('class_id') ?? $student->class_id;
        $student->section_id = $request->input('section_id') ?? $student->section_id;
        $student->school_house_id = $request->input('school_house_id') ?? $student->school_house_id;
        $student->guardian_name = $request->input('guardian_name') ?? $student->guardian_name;
        $student->guardian_relation = $request->input('guardian_relation') ?? $student->guardian_relation;
        $student->guardian_phone = $request->input('guardian_phone') ?? $student->guardian_phone;
        $student->guardian_email = $request->input('guardian_email') ?? $student->guardian_email;
        
        $student->save(); // Save the changes

        return redirect()->route('admin.students.index')->withToastSuccess('Student successfully updated');
    } catch (\Exception $e) {
        return back()->withToastError($e->getMessage())->withInput();
    }
    }

    public function destroy($id)
{
    try {
        // Find the student record
        $student = Student::findOrFail($id);

        // Start a database transaction
        DB::beginTransaction();

        // Delete related records first to avoid foreign key constraint violation

        // 1. Delete related student attendances (if any)
        $studentSessions = $student->studentSessions()->pluck('id'); // Get all student sessions related to the student
        StudentAttendance::whereIn('student_session_id', $studentSessions)->delete();

        // 2. Delete the associated User (if needed)
        $user = User::find($student->user_id);
        if ($user) {
            $user->delete();
        }

        // 3. Now delete the student record itself
        $student->delete();

        // Commit the transaction if all actions succeed
        DB::commit();

        return redirect()->back()->withToastSuccess('Student Successfully Deleted');
    } catch (\Exception $e) {
        // Rollback the transaction if there's any error
        DB::rollBack();
        return back()->withToastError($e->getMessage());
    }
}



public function destroyMultiple(Request $request)
{
    $studentIds = $request->input('studentIds');

    if (!is_array($studentIds) || empty($studentIds)) {
        return response()->json(['error' => 'No students selected for deletion.'], 400);
    }

    try {
        DB::beginTransaction();

        foreach ($studentIds as $id) {
            $student = Student::findOrFail($id);

            $studentSessions = $student->studentSessions()->pluck('id');
            StudentAttendance::whereIn('student_session_id', $studentSessions)->delete();

            $user = User::find($student->user_id);
            if ($user) {
                $user->delete();
            }

            $student->delete();
        }

        DB::commit();

        return response()->json(['success' => 'Students Successfully Deleted']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function saveRollNumber(Request $request)
{
    $rollNumbers = $request->input('rollNumbers');

    foreach ($rollNumbers as $rollNumberData) {
        $student = Student::find($rollNumberData['student_id']);
        if ($student) {
            $student->roll_no = $rollNumberData['roll_number'];
            $student->save();
        }
    }

    return response()->json(['success' => 'Roll numbers saved successfully.']);
}

    



public function getAllStudent(Request $request)
{
    if ($request->has('class_id') && $request->has('section_id')) {
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        $students = Student::with(['classes', 'user'])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();

        return Datatables::of($students)
            ->escapeColumns([])
            ->addColumn('checkbox', function($student) {
                return '<input type="checkbox" class="student-checkbox" data-student-id="' . $student->id . '">';
            })
            ->editColumn('f_name', function ($row) {
                return $row->user->f_name;
            })
            ->editColumn('l_name', function ($row) {
                return $row->user->l_name;
            })
            ->editColumn('class', function ($row) {
                return $row->classes->class;
            })
            ->editColumn('roll_no', function ($row) {
                return $row->roll_no;
            })
            ->editColumn('father_name', function ($row) {
                return $row->user->father_name;
            })
            ->editColumn('mother_name', function ($row) {
                return $row->user->mother_name;
            })
            ->editColumn('guardian_is', function ($row) {
                return $row->guardian_is;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addColumn('status', function ($row) {
                return $row->user->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                return view('backend.school_admin.student.partials.controller_action', ['student' => $row])->render();
            })
            ->make(true);
    }

    return Datatables::of([])->escapeColumns([])->make(true);
}

    

    // public function getAllStudent(Request $request)
    // {
    //     if ($request->has('class_id') && $request->has('section_id')) {
    //         $classId = $request->input('class_id');
    //         $sectionId = $request->input('section_id');

    //         // Pass only necessary parameters to getStudentsForDataTable
    //         $students = $this->studentUserService->getStudentsForDataTable($request)
    //             ->where('class_id', $classId)
    //             ->where('section_id', $sectionId);
    //         // ->get();

    //         // You don't need to check if $students is an instance of \Illuminate\Database\Query\Builder
    //         // because it's not possible for it to be anything else at this point.

    //         // You can remove the dd($students) line if you don't need it for debugging purposes.

    //         // Return the data using DataTables
    //         return Datatables::of($students)
    //             ->escapeColumns([])
    //             ->editColumn('f_name', function ($row) {
    //                 return $row->f_name;
    //             })
    //             ->editColumn('l_name', function ($row) {
    //                 return $row->l_name;
    //             })
    //             ->editColumn('roll_no', function ($row) {
    //                 return $row->roll_no;
    //             })
    //             ->editColumn('father_name', function ($row) {
    //                 return $row->father_name;
    //             })
    //             ->editColumn('mother_name', function ($row) {
    //                 return $row->mother_name;
    //             })
    //             ->editColumn('guardian_is', function ($row) {
    //                 return $row->guardian_is;
    //             })
    //             ->addColumn('created_at', function ($user) {
    //                 return $user->created_at->diffForHumans();
    //             })
    //             ->addColumn('status', function ($student) {
    //                 return $student->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
    //             })
    //             ->addColumn('actions', function ($student) {
    //                 return view(
    //                     'backend.school_admin.student.partials.controller_action',
    //                     ['student' => $student]
    //                 )->render();
    //             })
    //             ->make(true);
    //     }
    // }



    public function importAllStudentIndex()
    {
        $page_title = "Import Student";
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.student.importindex', compact('page_title', 'classes'));
    }

    public function downloadSampleFile()
    {
        $filePath = public_path('sample-files/sample.csv');

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, 'sample.csv');
        } else {
            abort(404, 'Sample file not found');
        }
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



                    $email = strtolower($row['f_name'] . '.' . $row['l_name'] . '.' . $row['admission_no'] . '@gmail.com');


                    // Check if the generated email already exists
                    $count = User::where('email', $email)->count();
                    if ($count > 0) {
                        // If the email already exists, append a number to make it unique
                        $email = strtolower($row['f_name'] . '.' . $row['l_name'] . '.' . $row['admission_no'] . $count . '@gmail.com');
                    }


                    $validator = Validator::make($row->toArray(), [

                        'state_id' => 'required',
                        'district_id' => 'required',
                        'municipality_id' => 'required',
                        'ward_id' => 'required',
                        'local_address' => 'nullable',
                        'permanent_address' => 'nullable',
                        'f_name' => 'required',
                        'l_name' => 'required',

                        'religion' => 'nullable',
                        'mobile_number' => 'nullable',
                        'gender' => 'required',
                        'dob' => 'required',
                        'blood_group' => 'nullable',
                        // 'image' => 'required',
                        'father_name' => 'nullable',
                        'father_phone' => 'nullable',
                        'father_occupation' => 'nullable',
                        'mother_name' => 'nullable',
                        'mother_phone' => 'nullable',
                        'mother_occupation' => 'nullable',
                        'emergency_contact_person' => 'nullable',
                        'emergency_contact_phone' => 'nullable',
                        'username' => 'nullable',
                        // 'password' => 'required',
                        'is_active' => 'boolean',
                        'guardian_is' => 'nullable',
                        'guardian_name' => 'nullable',
                        'guardian_phone' => 'nullable',
                        'guardian_relation' => 'nullable',
                        'guardian_email' => 'nullable',


                    ]);

                    if ($validator->fails()) {
                        // Redirect back with validation errors
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    // Validate user data
                    // $this->validateUserData($request);
                    $password = strtok($email, '@');
                    $username = strtok($email, '@');


                    $user_type_id = 8;
                    $role_id = 11;
                    $school_id = session('school_id');
                    $state_id = $row['state_id'];
                    $district_id = $row['district_id'];
                    $municipality_id = $row['municipality_id'];
                    $ward_id = $row['ward_id'];
                    $f_name = $row['f_name'];
                    $m_name = $row['m_name'];
                    $l_name = $row['l_name'];
                    // $email = 'email';
                    // 'email' => $email;
                    $local_address = $row['local_address'];
                    $permanent_address = $row['permanent_address'];
                    $gender = $row['gender'];
                    $religion = $row['religion'];
                    // $mobile_number = $row['mobile_number'];
                    $dob = $row['dob'];
                    $blood_group = $row['blood_group'];
                    $father_name = $row['father_name'];
                    $father_phone = $row['father_phone'];
                    $father_occupation = $row['father_occupation'];
                    $mother_name = $row['mother_name'];
                    $mother_phone = $row['mother_phone'];
                    $mother_occupation = $row['mother_occupation'];
                    $emergency_contact_person = $row['emergency_contact_person'];
                    $emergency_contact_phone = $row['emergency_contact_phone'];


                    $studentUser = User::create([
                        'user_type_id' => $user_type_id,
                        'role_id' => $role_id,
                        'school_id' => $school_id,
                        'state_id' => $state_id,
                        'district_id' => $district_id,
                        'municipality_id' => $municipality_id,
                        'ward_id' => $ward_id,
                        'f_name' => $f_name,
                        'm_name' => $m_name,
                        'l_name' => $l_name,
                        'email' => $email,
                        'local_address' => $local_address,
                        'permanent_address' => $permanent_address,
                        'password' => bcrypt($password),
                        'username' => $username,
                        'gender' => $gender,
                        'religion' => $religion,
                        'dob' => $dob,
                        'blood_group' => $blood_group,
                        'father_name' => $father_name,
                        'father_phone' => $father_phone,
                        'father_occupation' => $father_occupation,
                        'mother_name' => $mother_name,
                        'mother_phone' => $mother_phone,
                        'mother_occupation' => $mother_occupation,
                        'emergency_contact_person' => $emergency_contact_person,
                        'emergency_contact_phone' => $emergency_contact_phone,

                    ]);

                    $classId = $request->input('selected_class_id');
                    $sectionId = $request->input('selected_section_id');

                    // dd($sectionId);

                  // Use the method to create a student session
                  $this->createStudentSession($studentUser->id, $classId, $sectionId);

             
                    // CREATE STUDENT
                    // $reservation_quota_id = 1;
                    $admission_no = $row['admission_no'];
                    $roll_no = $row['roll_no'];
                    $admission_date = $row['admission_date'];
                    $school_house_id = $row['school_house_id'];
                    // $student_photo = $row['student_photo'];
                    $guardian_is = $row['guardian_is'];
                    $guardian_name = $row['guardian_name'];
                    $guardian_phone = $row['guardian_phone'];
                    $guardian_relation = $row['guardian_relation'];
                    $guardian_email = $row['guardian_email'];
                    // $transfer_certificate = $row['transfer_certificate'];

                    $studentCreate = Student::create([
                        'user_id' => $studentUser->id,
                        'school_id' => session('school_id'),
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        // 'reservation_quota_id' => $reservation_quota_id,
                        'admission_no' => $admission_no,
                        'roll_no' => $roll_no,
                        'admission_date' => $admission_date,
                        'school_house_id' => $school_house_id,
                        // 'student_photo' => $student_photo,
                        'guardian_is' => $guardian_is,
                        'guardian_name' => $guardian_name,
                        'guardian_phone' => $guardian_phone,
                        'guardian_relation' => $guardian_relation,
                        'guardian_email' => $guardian_email,
                        // 'transfer_certificate' => $transfer_certificate,
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


    public function exportSelected(Request $request)
    {
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        return Excel::download(new StudentsExport($classId, $sectionId), 'students.xlsx');
    }

    public function exportAll()
    {
        return Excel::download(new StudentsExport(), 'all_students.xlsx');
    }

}