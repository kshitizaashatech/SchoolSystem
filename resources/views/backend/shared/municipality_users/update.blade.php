@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.municipality_users.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST"
                                action="{{ route('admin.municipality-users.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Municipality Selection Section -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Municipality Selection:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group col-lg-6 col-sm-4">
                                        <label for="state_id">Choose State</label>
                                        <select id="state_id" name="state_id" data-iteration="0"
                                            class="form-control col-md-12 state_id" required>
                                            {{-- <option disabled selected value="{{ old('state_id', $user->state_id) }}">Choose
                                                State</option> --}}
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ $state->id == $user->state_id ? 'selected' : '' }}>
                                                    {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-sm-4">
                                        <label for="district_id">Choose District</label>
                                        <select id="district_id" name="district_id" data-iteration="0"
                                            class="form-control col-md-12 district_id" required>
                                            @foreach ($user->district_bystate($user->state_id) as $state_district)
                                                <option value="{{ $state_district->id }}"
                                                    {{ $user->district_id == $state_district->id ? ' selected' : '' }}>
                                                    {{ $state_district->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('district_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-6 col-sm-4">
                                        <label for="municipality_id">Choose Municipality</label>
                                        <select id="municipality_id" name="municipality_id" data-iteration="0"
                                            class="form-control col-md-12 municipality_id" required>
                                            @foreach ($user->municipalities_bydistrict($user->district_id) as $district_municipality)
                                                <option value="{{ $district_municipality->id }}"
                                                    {{ $user->municipality_id == $district_municipality->id ? 'selected' : '' }}>
                                                    {{ $district_municipality->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('municipality_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <!-- General Information Section -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Municipality Applicant's General Information:</h5>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="f_name">First Name</label>
                                        <input type="text" name="f_name"
                                            class="form-control @error('f_name') is-invalid @enderror" id="f_name"
                                            value="{{ old('f_name', $user->f_name) }}" placeholder="Enter First Name"
                                            required>
                                        @error('f_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="m_name">Middle Name</label>
                                        <input type="text" name="m_name" value="{{ old('m_name', $user->m_name) }}"
                                            class="form-control" id="m_name" placeholder="Enter Middle Name" required>
                                        @error('m_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="l_name">Last Name</label>
                                        <input type="text" name="l_name" value="{{ old('l_name', $user->l_name) }}"
                                            class="form-control" id="l_name" placeholder="Enter Last Name" required>
                                        @error('l_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" id="email"
                                            placeholder="Enter Email" required>
                                        @error('email')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="mobile_number">Mobile No</label>
                                        <input type="mobile_number" name="mobile_number"
                                            value="{{ old('mobile_number', $user->mobile_number) }}" class="form-control"
                                            id="mobile_number" placeholder="Enter Mobile" required>
                                        @error('mobile_number')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Enter Password" value="">
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                            </span>
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password">Password Confirmation</label>
                                            <input id="password-confirm" type="password"
                                                value="{{ old('password_confirmation') }}" placeholder="Confirm Password"
                                                class="form-control" name="password_confirmation">
                                        </div>
                                    </div> --}}


                                    <!-- Profile Picture Section -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Municipality Applicant's Profile Picture:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4">
                                        {{-- <img src="{{ $user->profile_picture_url }}" id="image" style="width: 20%;"> --}}
                                        <img src="{{ asset($user->image) }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                                name="image" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePreview" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic"
                                                tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage"
                                                style="margin-top: 7px;">Remove</button>
                                        </div>
                                    </div>

                                    <!-- Users Status Section -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>Users Status:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4">
                                        <div class="col-sm-10">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_active" id="option1"
                                                    value="1" autocomplete="off"
                                                    @if ($user->is_active == 1) checked @endif>
                                                {{-- {{ $user->is_active == 1 ? 'checked' : '' }}> --}}
                                                <label class="btn btn-secondary" for="option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_active" id="option2"
                                                    value="0" autocomplete="off"
                                                    @if ($user->is_active == 0) checked @endif>
                                                {{-- {{ $user->is_active == 0 ? 'checked' : '' }}> --}}
                                                <label class="btn btn-secondary" for="option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="hr-line-dashed"></div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success pull-right">Update</button>
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
            $(document).on('change', '.state_id', function() {
                var state_id = $(this).val();
                var currentiteration = $(this).data("iteration");
                var append_to = 'district_id';
                $.ajax({
                    url: '/admin/get-district-by-state/' + state_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose District</option>');
                            $.each(response, function(key, value) {
                                $('#' + append_to + '').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No districts found</option>');
                        }

                        // Clear the municipalities dropdown when the state changes
                        $('#municipalitiy_id').empty().append(
                            '<option value="">Choose Municipality</option>');
                    },
                    error: function() {
                        console.log("error in the ajax");
                    }
                });
            });

            $(document).on('change', '.district_id', function() {
                var district_id = $(this).val();
                var currentiteration = $(this).data("iteration");
                var append_to = 'municipality_id';
                $.ajax({
                    url: '/admin/get-municipality-by-district/' + district_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose Municipality</option>'
                            );
                            $.each(response, function(key, value) {
                                console.log(value.name);
                                $('#' + append_to + '').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No municipalities found</option>');
                        }
                    },
                    error: function() {
                        console.log("error in the ajax");
                    }
                });
            });
        });
    </script>
@endsection
