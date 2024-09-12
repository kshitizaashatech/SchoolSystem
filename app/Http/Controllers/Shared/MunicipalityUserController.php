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

class MunicipalityUserController extends Controller
{

    protected $formService;

    protected $imageSavePath = '/uploads/users/';

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }
    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }

    public function getMunicipality($district_id)
    {

        $municipalities = $this->formService->getMunicipalities($district_id);
        return response()->json($municipalities);
    }

    public function index()
    {

        $page_title = 'Municipality User Listing';

        return view('backend.shared.municipality_users.index', compact('page_title'));
    }
    public function create()
    {

        $states = $this->formService->getProvinces();

        $page_title = 'Municipality Create Form';

        return view('backend.shared.municipality_users.create', compact('states', 'page_title'));
    }
    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);

        $user->syncRoles($request->input('roles', []));

        return redirect()->route('admin.municipality_users.index')->with('success', 'Roles updated successfully');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            // 'ward_id' => 'required',
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
            $input['role_id'] = 3;
            $input['user_type_id'] = 3; //1 being district user
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
                $user->assignRole('Super Admin');
                return redirect()->route('admin.municipality-users.index')->withToastSuccess('Municipality User Successfully Registered!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
            ;
        }
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $page_title = 'Municipality User Edit Form';
        $states = $this->formService->getProvinces();

        return view('backend.shared.municipality_users.update', compact('user', 'states', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            // 'ward_id' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'mobile_number' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        try {

            $input = array_filter($request->all(), function ($value) {
                return $value !== null;
            });
            $user = User::findorfail($id);
            if ($request->password) {

                $input['password'] = Hash::make($input['password']);
            }
            $input['device'] = 'web';
            $input['user_type_id'] = 3; //1 being district user
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                $path = public_path() . $user->image;
                \File::delete($path);
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['image'] = $destinationPath;
            }
            $user = $user->update($input);
            if ($user) {
                // $user->assignRole('Super Admin');
                return redirect()->route('admin.municipality-users.index')->withToastSuccess('Municipality User Successfully Updated!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user->delete()) {
            $path = public_path() . $user->image;
            \File::delete($path);
            return redirect()->back()->withToastSuccess('Municipality User Successfully Deleted!');
        } else {
            return back()->withToastError('An error occurred while performing the operation.');
        }
    }

    public function getAllMunicipalityUsers(Request $request)
    {
        $user = $this->getForDataTable($request->all());
        // dd($user);
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
            ->addColumn('municipality_name', function ($user) {
                return $user->municipality->name;
            })
            ->addColumn('full_name', function ($user) {
                return $user->f_name . ' ' . $user->l_name;
            })
            ->addColumn('status', function ($user) {
                return $user->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';

            })

            ->addColumn('actions', function ($user) {
                return view('backend.shared.municipality_users.partials.controller_action', ['user' => $user])->render();
            })

            ->make(true);
    }
    public function getForDataTable($request)
    {
        $dataTableQuery = UserService::getUsers(3)->except(Auth::id()); //3 role municipility user
        return $dataTableQuery;
    }
}