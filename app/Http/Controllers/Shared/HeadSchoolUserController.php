<?php

namespace App\Http\Controllers\Shared;

use Log;
use App\Models\cr;
use App\Models\User;
use App\Models\State;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Http\JsonResponse;
use App\Http\Services\FormService;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image, View, File;
use Illuminate\Support\Facades\Hash;

class HeadSchoolUserController extends Controller
{
    protected $formService;
    protected $imageSavePath = '/uploads/users/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Head School User Listing';
        return view('backend.shared.head_school_users.index', compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $head_schools = School::where('head_school', 1)->get();

        // dd($head_schools);

        $page_title = 'Head School User Create Form';

        return view('backend.shared.head_school_users.create', compact('page_title', 'head_schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'school_id' => 'required',
            'f_name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'phone' => 'required',
        ]);

        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['device'] = 'web';
            $input['role_id'] = 4;
            $input['user_type_id'] = 4;

            $user = User::create($input);

            // dd($user);
            if ($user) {
                // Assign the 'Head School' role to the user
                $user->assignRole('Head School');
                return redirect()->back()->withToastSuccess('Head School User Successfully Registered!');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $head_school = User::find($id);
            $page_title = 'Head School User Edit Form';
            $head_schools = School::all();

            return view('backend.shared.head_school_users.update', compact('head_schools', 'page_title', 'head_school'));
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'school_id' => 'required',
            'f_name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'phone' => 'required',
        ]);

        try {

            $input = array_filter($request->all(), function ($value) {
                return $value !== null;
            });

            // Find the user by ID
            $user = User::findOrFail($id);

            if ($request->password) {
                $input['password'] = Hash::make($input['password']);
            }

            $input['device'] = 'web';
            $input['user_type_id'] = 4;


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

            return redirect()->back()->withToastSuccess('Head School User information updated successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

        /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $head_school = User::findOrFail($id);
            $head_school->delete();

            return redirect()->back()->withToastSuccess('Head School Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function getSchoolDetails($id)
    {
        $school = School::find($id);

        return response()->json([
            'name' => $school->name,
            'email' => $school->email,
            'phone' => $school->phone_number,
        ]);
    }

    public function getAllHeadSchoolUsers(Request $request)
    {
        $user = $this->getForDataTable($request->all());
        // dd($user);
        return Datatables::of($user)

            ->editColumn('f_name', function ($row) {
                return $row->f_name;
            })
            ->editColumn('email', function ($row) {
                return $row->email;
            })
            ->editColumn('username', function ($row) {
                return $row->username;
            })
            ->editColumn('password', function ($row) {
                return $row->password;
            })
            ->editColumn('password_confirmation', function ($row) {
                return $row->password_confirmation;
            })
            ->editColumn('phone', function ($row) {
                return $row->phone;
            })

            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })

            ->addColumn('status', function ($user) {
                return $user->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($user) {
                return view('backend.shared.head_school_users.partials.controller_action', ['user' => $user])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = UserService::getUsers(4)->except(Auth::id()); //4 role head school user
        return $dataTableQuery;
    }





}
