<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use App\Http\Services\UserService;
use App\Http\Services\FormService;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\UserType;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role;
use Image, View, File;
use Carbon\Carbon;
use Alert;
use Validator;

class SchoolAdminUserController extends Controller
{
    protected $imageSavePath = '/uploads/users/';
    public function index()
    {

        $page_title = 'School Admin User Listing';

        return view('backend.shared.schooladmin_users.index', compact('page_title'));
    }
    public function create()
    {
        // $states = $this->formService->getProvinces();
        $page_title = 'School Admin User Create Form';
        return view('backend.shared.schooladmin_users.create', compact('page_title'));
    }
    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);

        $user->syncRoles($request->input('roles', []));

        return redirect()->route('admin.schooladmin_users.index')->with('success', 'Roles updated successfully');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'mobile_number' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);


        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['device'] = 'web';
            $input['role_id'] = 5;
            $input['user_type_id'] = 5; //5 being school_admin user

            // Set the default school_id to 1
            // $input['school_id'] = 1;

            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['image'] = $destinationPath;
            }
            $user = User::create($input);
            if ($user) {
                $user->assignRole('School Admin');
                return redirect()->route('admin.school-adminusers.index')->withToastSuccess('Super Admin User Successfully Registered!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
            ;
        }
    }
    public function edit($id)
    {
        $user = User::find($id);
        $page_title = 'School Admin User Edit Form';

        return view('backend.shared.schooladmin_users.update', compact('user', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        try {
            $input = array_filter($request->all(), function ($value) {
                return $value !== null;
            });

            $user = User::findOrFail($id);

            if ($request->password) {
                $input['password'] = Hash::make($input['password']);
            }

            $input['device'] = 'web';
            $input['user_type_id'] = 5; // Assuming 5 is the user type for School Admin

            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                $path = public_path() . $user->image;
                File::delete($path);
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['image'] = $destinationPath;
            }

            $user->update($input);

            return redirect()->route('admin.school-adminusers.index')->withToastSuccess('School Admin User Successfully Updated!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            $path = public_path() . $user->image;
            \File::delete($path);
            return redirect()->back()->withToastSuccess('School Admin User Successfully Deleted!');
        } else {
            return back()->withToastError('An error occurred while performing the operation.');
        }
    }
    
    public function getAllSchoolAdminUsers(Request $request)
    {
        $user = $this->getForDataTable($request->all());

        return Datatables::of($user)
            ->editColumn('email', function ($row) {
                return $row->email;
            })
            ->editColumn('mobile_number', function ($row) {
                return $row->mobile_number;
            })
            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })
            // ->addColumn('municipality_name', function ($user) {
            //     return $user->municipality->name;
            // })
            ->addColumn('full_name', function ($user) {
                return $user->f_name . ' ' . $user->l_name;
            })
            ->addColumn('status', function ($user) {
                return $user->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';

            })

            ->addColumn('actions', function ($user) {
                return view('backend.shared.schooladmin_users.partials.controller_action', ['user' => $user])->render();
            })

            ->make(true);
    }
    public function getForDataTable($request)
    {
        $dataTableQuery = UserService::getUsers(5)->except(Auth::id());

        return $dataTableQuery;
    }

}