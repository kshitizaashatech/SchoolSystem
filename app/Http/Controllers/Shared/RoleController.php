<?php

namespace App\Http\Controllers\Shared;

use App\Models\UserType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{

    public function index()
    {
        $page_title = "Roles Listing";
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('backend.shared.roles.index', compact('roles', 'permissions', 'page_title'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        try {

            $request->validate([
                'permissions' => 'array',
            ]);

            // Sync the permissions for the role
            $role->syncPermissions($request->input('permissions'));

            return redirect()->route('admin.roles.index')->withToastSuccess('Permissions updated successfully');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function create()
    {
        $permissions = Permission::all();

        return view('backend.shared.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        try {
            // Create the role
            $role = Role::create(['name' => $request->name]);

            // Get all permissions
            $allPermissions = Permission::all();

            // Loop through each permission
            foreach ($allPermissions as $permission) {
                // Check if the permission is selected in the form
                $isSelected = $request->has('permissions') && in_array($permission->name, $request->permissions);

                // If selected, assign the permission to the role
                if ($isSelected) {
                    $role->givePermissionTo($permission);
                } else {
                    // If not selected, remove the permission from the role (if it was assigned previously)
                    $role->revokePermissionTo($permission);
                }
            }

            return redirect()->route('admin.roles.index')->withToastSuccess('Role created successfully');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function show(Request $request)
    {
        dd("This is show");
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('backend.shared.roles.update', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {

        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'array',
            ]);

            // Retrieve the role from the database
            $existingRole = Role::find($request->dynamic_id);

            // Update the role name
            $existingRole->name = $request->name;

            // Sync the permissions
            $permissions = $request->input('permissions', []);
            $existingRole->syncPermissions($permissions);

            // Save the changes
            $existingRole->save();

            return redirect()->route('admin.roles.index')
                ->withTostSuccess('Role updated successfully');
                
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function destroy($id)
    {

        try {
            $role = Role::find($id);
            $role->delete();
    
            return redirect()->route('admin.roles.index')
                ->withToastSuccess('Role deleted successfully');
        } catch (\Exception $th) {
            return back()->withToastError($e->getMessage());
        }

    }



    public function getAllRoles(Request $request)
    {
        $role = $this->getForDataTable($request->all());

        return Datatables::of($role)
            ->escapeColumns([])
            ->addColumn('created_at', function ($role) {
                return $role->created_at->diffForHumans();
            })
            ->addColumn('role', function ($role) {
                return $role->name;
            })
            ->addColumn('permissions', function ($role) {
                // Assuming $role->permissions is a collection of Permission models
                $permissions = $role->permissions->pluck('name')->implode(', ');
                return $permissions;
            })

            ->addColumn('actions', function ($role) {
                return '
                <button type="button" class="btn btn-outline-primary btn-sm mx-1 role-permission-modal" data-bs-toggle="modal"
                data-bs-target="#permissionModal" data-role-id="' . $role->id . '">
                <i class="fas fa-check"></i>
                </button>
                
                <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-role"
                            data-id="' . $role->id . '" data-name="' . $role->name . '" data-toggle="tooltip"
                            data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
        
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
            data-bs-target="#delete' . $role->id . '"  data-toggle="tooltip" data-placement="top" title="Delete">
            <i class="far fa-trash-alt"></i>
        </button>

        <div class="modal fade" id="delete' . $role->id . '" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="' . route('admin.roles.destroy', $role->id) . '" accept-charset="UTF-8" method="POST">
                        <div class="modal-body">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="' . csrf_token() . '">
                            <p>Are you sure to delete <span class="must" id="underscore"> ' . $role->name . ' </span>?</p>
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
        $dataTableQuery = Role::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }
}
