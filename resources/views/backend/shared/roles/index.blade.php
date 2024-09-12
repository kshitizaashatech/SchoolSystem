@extends('backend.layouts.master')

<!-- Main content -->
@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">

            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
            @include('backend.shared.roles.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="role-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Permissions</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="rolesForm" action="{{ route('admin.roles.store') }}">
                            @csrf
                            <div class="col-md-12">
                                <div class="p-2 label-input ">
                                    <label>Name <span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input id="createInput" type="text" name="name"
                                            class="input-text single-input-text" autofocus required
                                            onkeyup="replaceFunction(this.value)">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5>
                                        <input type="checkbox" id="selectAllPermissions"> Select All Permissions
                                    </h5>

                                    <div class="col mt-3">
                                        <div class="col-md-3 mt-3">
                                            <h6 class="text-decoration-underline fw-bolder ">Create</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'create_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6 class="text-decoration-underline fw-bolder">View</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'list_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6  class="text-decoration-underline fw-bolder">Edit</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'edit_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6  class="text-decoration-underline fw-bolder">Delete</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'delete_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================

            MODAL - GIVE PERMISSION
            
        ====================================     --}}
        <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modify Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form id="rolePermissionsForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_method" id="permissionmethodField">

                            <div class="card-body">
                                <h5>
                                    <input type="checkbox" id="selectPermissions"> Select All Permissions
                                </h5>

                                <div class="col mt-3">
                                    <div class="col-md-3 mt-3">
                                        <h6 class="text-decoration-underline">Create</h6>
                                        @foreach ($permissions->filter(function ($permission) {
        return Str::startsWith($permission->name, 'create_');
    }) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" class="form-check-input">
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <h6 class="text-decoration-underline">View</h6>
                                        @foreach ($permissions->filter(function ($permission) {
        return Str::startsWith($permission->name, 'list_');
    }) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" class="form-check-input">
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <h6  class="text-decoration-underline">Edit</h6>
                                        @foreach ($permissions->filter(function ($permission) {
        return Str::startsWith($permission->name, 'edit_');
    }) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" class="form-check-input">
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <h6  class="text-decoration-underline">Delete</h6>
                                        @foreach ($permissions->filter(function ($permission) {
        return Str::startsWith($permission->name, 'delete_');
    }) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" class="form-check-input">
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                <button type="submit" class="btn btn-sm btn-primary mt-2">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>



        {{-- ===================================================================

                        EDIT MODAL

        =================================================================== --}}

        <div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form id="editRolesForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_method" id="methodField">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label>Name<span class="must" id="permissionName">*</span></label>
                                    <div class="col-sm-10 single-input-modal">
                                        <input type="text" name="name" class="editinput-text single-input-text" id="dynamic_name"
                                            autofocus required onkeyup="replaceFunctionTwo(this.value)">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5>
                                        <input type="checkbox" id="selectAllupPermissions"> Select All Permissions
                                    </h5>

                                    <div class="col mt-3">
                                        <div class="col-md-3 mt-3">
                                            <h6 class="text-decoration-underline fw-bolder">Create</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'create_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6  class="text-decoration-underline fw-bolder">View</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'list_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6 class="text-decoration-underline fw-bolder">Edit</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'edit_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <h6 class="text-decoration-underline fw-bolder">Delete</h6>
                                            @foreach ($permissions->filter(function ($permission) {
            return Str::startsWith($permission->name, 'delete_');
        }) as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" class="form-check-input">
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.roles.get') }}',
                type: 'post'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'permissions',
                    name: 'permissions'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val()).draw();
                        });
                });
            }
        });

        $(document).on('click', '.role-permission-modal', function() {
            var roleId = $(this).data('role-id');
            var formAction = '{{ route('admin.roles.permissions', '') }}' + '/' + roleId;

            console.log(roleId);
            console.log(formAction);

            // Set the form action
            $('#rolePermissionsForm').attr('action', formAction);
            $('#permissionmethodField').val('PUT');

            // Show the modal
            $('#permissionModal').modal('show');
        });



        //edit funcion
        $(document).on('click', '.edit-role', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var name = $(this).data('name');

            console.log(id);
            console.log(name);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);


            $('#editRolesForm').attr('action', '{{ route('admin.roles.update', '') }}' + '/' + id);

            $('#methodField').val('PUT');

            // Show the modal
            $('#editRole').modal('show');

            // Prevent the default anchor behavior
            return false;

        });

        function replaceFunctionTwo(val) {
            var element = document.querySelector('.editinput-text');
            element.value = val.replace(' ', '_');

            console.log(element.value);
        }

        function replaceFunction(val) {
            document.getElementById('createInput').value = val.replace(' ', '_');
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Get the 'Select All Permissions' checkbox
            const selectAllCheckbox = document.getElementById('selectAllupPermissions');

            // Get all permission checkboxes
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

            // Add event listener to 'Select All Permissions' checkbox
            selectAllCheckbox.addEventListener('change', function() {
                // Iterate through each permission checkbox and set its checked property
                permissionCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });


            // Get the 'Select All Permissions' checkbox
            const selectAllCheckbox1 = document.getElementById('selectAllPermissions');

            // Get all permission checkboxes
            const permissionCheckboxes1 = document.querySelectorAll('input[name="permissions[]"]');

            // Add event listener to 'Select All Permissions' checkbox
            selectAllCheckbox1.addEventListener('change', function() {
                // Iterate through each permission checkbox and set its checked property
                permissionCheckboxes1.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox1.checked;
                });
            });

            // Get the 'Select All Permissions' checkbox
            const selectAllCheckbox2 = document.getElementById('selectPermissions');

            // Get all permission checkboxes
            const permissionCheckboxes2 = document.querySelectorAll('input[name="permissions[]"]');

            // Add event listener to 'Select All Permissions' checkbox
            selectAllCheckbox2.addEventListener('change', function() {
                // Iterate through each permission checkbox and set its checked property
                permissionCheckboxes2.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox2.checked;
                });
            });
        });
    </script>
@endsection
@endsection
