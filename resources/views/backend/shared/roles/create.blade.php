@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    @include('backend.includes.forms')

    <div class="card-header">
        <h1 class="card-title">Add Role</h1>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Role: </label>
                <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Name">
            </div>

        </div>

        <div class="card-body">
            <h5>
                <input type="checkbox" id="selectAllPermissions"> Select All Permissions
            </h5>

            <div class="row mt-3">
                <div class="col-md-3 mt-3">
                    <h6>Create</h6>
                    @foreach ($permissions->filter(function ($permission) { return Str::startsWith($permission->name, 'create_');}) as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                class="form-check-input">
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3 mt-3">
                    <h6>View</h6>
                    @foreach ($permissions->filter(function ($permission) {return Str::startsWith($permission->name, 'list_');}) as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                class="form-check-input">
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3 mt-3">
                    <h6>Edit</h6>
                    @foreach ($permissions->filter(function ($permission) {return Str::startsWith($permission->name, 'edit_');}) as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                class="form-check-input">
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3 mt-3">
                    <h6>Delete</h6>
                    @foreach ($permissions->filter(function ($permission) {return Str::startsWith($permission->name, 'delete_');}) as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                class="form-check-input">
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the 'Select All Permissions' checkbox
            const selectAllCheckbox = document.getElementById('selectAllPermissions');

            // Get all permission checkboxes
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

            // Add event listener to 'Select All Permissions' checkbox
            selectAllCheckbox.addEventListener('change', function() {
                // Iterate through each permission checkbox and set its checked property
                permissionCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
    </script>
@endsection
