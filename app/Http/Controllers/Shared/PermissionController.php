<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
// Use Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $page_title = "Permission Listing";
        $permissions = Permission::all();

        return view('backend.shared.permissions.index', compact('permissions', 'page_title'));
    }

    public function create()
    {
        return view('backend.shared.permissions.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ]);
    
        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }
    
        try {
            $basePermissionName = $request->input('name');
    
            // Create an array of permission names
            $permissionNames = [
                'create_' . $basePermissionName,
                'list_' . $basePermissionName,
                'edit_' . $basePermissionName,
                'delete_' . $basePermissionName,
            ];
    
            // Iterate over the permission names and create each permission
            foreach ($permissionNames as $permissionName) {
                Permission::create(['name' => $permissionName]);
            }
    
            return redirect()->back()->withToastSuccess('Permissions Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    

    public function show(Request $request)
    {
        // dd($request);
    }


    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('backend.shared.permissions.update', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        if ($validator->fails()) {

            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        try {
            // $permission = Permission::find($request->id);
            $permission->name = $request->name;

            $permission->save();

            return redirect()->back()->withToastSuccess('Successfully Updated Permission!');
        } catch (\Throwable $th) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Permission  Please try again')->withInput();
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);

        try {
            $updateNow = $permission->delete();
            return redirect()->back()->withToastSuccess('Permission has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }


    public function getAllPermission(Request $request)
    {
        $permission = $this->getForDataTable($request->all());

        return Datatables::of($permission)
            ->escapeColumns([])
            ->addColumn('created_at', function ($permission) {
                return $permission->created_at->diffForHumans();
            })
            ->addColumn('permission', function ($permission) {
                return $permission->name;
            })

            ->addColumn('actions', function ($permission) {
                return '<a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-permission"
                            data-id="' . $permission->id . '" data-name="' . $permission->name . '" data-toggle="tooltip"
                            data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
        
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
            data-bs-target="#delete' . $permission->id . '"  data-toggle="tooltip" data-placement="top" title="Delete">
            <i class="far fa-trash-alt"></i>
        </button>

        <div class="modal fade" id="delete' . $permission->id . '" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="' . route('admin.permissions.destroy', $permission->id) . '" accept-charset="UTF-8" method="POST">
                        <div class="modal-body">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="' . csrf_token() . '">
                            <p>Are you sure to delete <span id="underscore"> ' . $permission->name . ' </span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

         ';
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
        /**
         * 
         */
        $dataTableQuery = Permission::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
