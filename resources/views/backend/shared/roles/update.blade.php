@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    @include('backend.includes.forms')

    <div class="card-header">
        <h1 class="card-title">Update Role</h1>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.roles.update', ['role' => $role->id]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $role->id }}">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Role: </label>
                <input type="text" name="name" class="form-control" id="exampleInputName" value="{{ $role->name }}">
            </div>

            <div class="row mt-3">
                <h5>
                    <input type="checkbox" id="selectAllPermissions"> Select All Permissions
                </h5>
                @foreach(['create', 'view', 'edit', 'delete'] as $type)
                    <div class="col-md-3 mt-3">
                        <h6>{{ ucfirst($type) }}</h6>
                        @foreach ($permissions->filter(function ($permission) use ($type) {
                            return Str::startsWith($permission->name, $type.'_');
                        }) as $permission)
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} class="form-check-input">
                                <label class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
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
