<?php

namespace App\Http\Controllers\SuperAdmin;

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

class DistrictUserController extends Controller
{

    protected $formService;

    protected $imageSavePath = '/uploads/users/';

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page_title = 'District User Listing';

        return view('backend.shared.district_users.index', compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = $this->formService->getProvinces();
        $page_title = 'District User Create Form';
        return view('backend.shared.district_users.create', compact('states', 'page_title'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }

    /**
     * To change user's roles
     */
    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);

        $user->syncRoles($request->input('roles', []));

        return redirect()->route('admin.district_users.index')->with('success', 'Roles updated successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'state_id' => 'required',
            'district_id' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'mobile_number' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        // $validator = Validator::make($request->all(), [
        //     'state_id' => 'required',
        //     'district_id' => 'required',
        //     'username' => 'required',
        //     'f_name' => 'required',
        //     'l_name' => 'required',
        //     'mobile_number' => 'required',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'email' => 'required|unique:users,email',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {

        //     return back()->withToastError($validator->messages()->all())->withInput();
        // }

        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['device'] = 'web';
            $input['role_id'] = 2;
            $input['user_type_id'] = 2; //1 being district user
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
                return redirect()->route('admin.district-users.index')->withToastSuccess('District User Successfully Registered!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
            ;
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
        $user = User::find($id);
        $page_title = 'District User Edit Form';
        $states = $this->formService->getProvinces();

        return view('backend.shared.district_users.update', compact('user', 'states', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'state_id' => 'required',
            'district_id' => 'required',
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
            $input['user_type_id'] = 2; //1 being district user
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
                return redirect()->route('admin.district-users.index')->withToastSuccess('District User Successfully Updated!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user->delete()) {
            $path = public_path() . $user->image;
            \File::delete($path);
            return redirect()->back()->withToastSuccess('District User Successfully Deleted!');
        } else {
            return back()->withToastError('An error occurred while performing the operation.');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllDistrictUsers(Request $request)
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
            ->addColumn('district_name', function ($user) {
                return $user->district->name;
            })
            ->addColumn('full_name', function ($user) {
                return $user->f_name . ' ' . $user->l_name;
            })
            ->addColumn('status', function ($user) {
                return $user->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';

            })

            ->addColumn('actions', function ($user) {
                return view('backend.shared.district_users.partials.controller_action', ['user' => $user])->render();
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
        $dataTableQuery = UserService::getUsers(2)->except(Auth::id()); //2 role district user
        /**
         * 
         */

        // $dataTableQuery = User::where(function ($query) use ($request) {
        //     if (isset($request->id)) {
        //         $query->where('id', $request->id);
        //         }
        //     })
        //     ->get();

        return $dataTableQuery;
    }
}
