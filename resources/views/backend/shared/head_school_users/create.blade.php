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
            @include('backend.shared.head_school_users.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST"
                                action="{{ route('admin.head-schoolusers.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-6 col-sm-4">
                                        <label for="school_id">Choose Head School</label>
                                        {{-- id="school_id" --}}
                                        <select id="head_school_id" name="school_id" class="form-control col-md-12"
                                            required>
                                            <option disabled selected value="{{ old('school_id') }}">Select Head School
                                            </option>
                                            @foreach ($head_schools as $head_school)
                                                <option value="{{ $head_school->id }}">{{ $head_school->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('head_school_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="f_name">School Name</label>
                                        <input type="text" name="f_name"
                                            class="form-control @error('f_name') is-invalid @enderror" id="f_name"
                                            value="{{ old('f_name') }}" placeholder="Enter School Name" required>
                                        @error('f_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email') }}" id="email" placeholder="Enter Email" required>
                                        @error('email')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="username">Username</label>
                                        <input type="username" name="username" class="form-control"
                                            value="{{ old('username') }}" id="username" placeholder="Enter Username"
                                            required>
                                        @error('username')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="phone">Phone No</label>
                                        <input type="phone" name="phone" value="{{ old('phone') }}"
                                            class="form-control" id="phone" placeholder="Enter Phone No" required>
                                        @error('phone')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" value="{{ old('password') }}"
                                                id="password" name="password" placeholder="Enter Password" value="">
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password">Password Confirmation</label>
                                            <input id="password-confirm" type="password"
                                                value="{{ old('password_confirmation') }}" placeholder="Confirm Password"
                                                class="form-control" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="label-input">
                                        <label>Status<span class="must">*</span></label>
                                        <div class="col-sm-10">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_active" id="option1"
                                                    value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_active" id="option2"
                                                    value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="hr-line-dashed"></div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success pull-right">Create</button>
                                </div>
                                <div class="hr-line-dashed"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.includes.modal')
@endsection
@section('scripts')
    @include('backend.includes.cropperjs')

    <script>
        $(document).ready(function() {
            // Add change event listener to the dropdown
            $('#head_school_id').change(function() {
                // Get the selected option value
                var selectedSchoolId = $(this).val();

                // Make an AJAX request to fetch the details of the selected school
                $.ajax({
                    url: 'get-school-details/' +
                    selectedSchoolId, // Replace with your actual route
                    type: 'GET',
                    success: function(data) {
                        // Populate the form fields with the retrieved data
                        $('#f_name').val(data.name);
                        $('#email').val(data.email);
                        $('#phone').val(data.phone);
                    },
                    error: function() {
                        console.log('Error fetching school details');
                    }
                });
            });
        });
    </script>
@endsection
