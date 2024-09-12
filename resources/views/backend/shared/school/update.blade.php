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
            @include('backend.shared.school.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST"
                                action="{{ route('admin.schools.update', $school->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="hr-line-dashed"></div>
                                    <h5>Location Selection:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <label for="state_id">Choose State</label><span class="must"> *</span>
                                            <div class="select">

                                                <select id="state_id" name="state_id" data-iteration="0" class="state_id"
                                                    required>
                                                    <option disabled value=""
                                                        {{ old('state_id', $school->state_id) ? '' : 'selected' }}>Choose
                                                        State
                                                    </option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}"
                                                            {{ old('state_id', $school->state_id) == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('state_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <label for="district_id">Choose District</label><span class="must"> *</span>
                                            <div class="select">

                                                <select id="district_id" name="district_id" data-iteration="0"
                                                    class="district_id" required>
                                                    @foreach ($school->district_bystate($school->state_id) as $state_district)
                                                        <option value="{{ $state_district->id }}"
                                                            {{ $school->district_id == $state_district->id ? ' selected' : '' }}>
                                                            {{ $state_district->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('district_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <label for="municipalitiy_id">Choose Municipality</label><span class="must">
                                                *</span>
                                            <div class="select">

                                                <select id="municipalitiy_id" name="municipality_id" data-iteration="0"
                                                    class="municipality_id" required>
                                                    @foreach ($school->municipalitiesByDistrict($school->district_id) as $district_municipality)
                                                        <option value="{{ $district_municipality->id }}"
                                                            {{ $school->municipality_id == $district_municipality->id ? ' selected' : '' }}>
                                                            {{ $district_municipality->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('municipalitiy_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <label for="ward_id">Choose Ward</label><span class="must"> *</span>
                                            <div class="select">

                                                <select id="ward_id" name="ward_id" data-iteration="0" class="ward_id"
                                                    required>
                                                    <option value="{{ old('ward_id') }}">Choose Ward</option>

                                                    @foreach ($school->wardsByMunicipality($school->municipality_id) as $ward)
                                                        <option value="{{ $ward }}"
                                                            {{ $school->ward_id == $ward ? ' selected' : '' }}>
                                                            {{ $ward }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @error('ward_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5>School's General Information:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-6">
                                            <label for="school_type">School Type</label><span class="must"> *</span>
                                            <div class="select">
                                                <select name="school_type" id="school_type" class="" required>
                                                    <option value="pre-primary" {{ $school->school_type == 'pre-primary' ? 'selected' : '' }}>Pre Primary</option>
                                                    <option value="primary" {{ $school->school_type == 'primary' ? 'selected' : '' }}>Primary</option>
                                                    <option value="lower-secondary" {{ $school->school_type == 'lower-secondary' ? 'selected' : '' }}>Lower Secondary</option>
                                                    <option value="secondary" {{ $school->school_type == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                    <option value="higher-secondary" {{ $school->school_type == 'higher-secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                                </select>
                                            </div>
                                            @error('school_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                            <label for="school_code">School Code</label><span class="must"> *</span>
                                            <input type="text" name="school_code" value="{{ $school->school_code }}" class="form-control" id="school_code" required>
                                            @error('school_code')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-6">
                                            <label for="head_teacher">Head Teacher</label><span class="must"> *</span>
                                            <input type="text" name="head_teacher" value="{{ $school->head_teacher }}" class="form-control" id="head_teacher" required>
                                            @error('head_teacher')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="name"> Name</label><span class="must"> *</span>
                                        <input type="text" name="name" value="{{ $school->name }}"
                                            class="form-control" id="name" required>
                                        @error('name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="address">Address</label><span class="must"> *</span>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $school->address }}" id="address" required>
                                        @error('address')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="phone_number">Phone No</label><span class="must"> *</span>
                                        <input type="phone_number" name="phone_number"
                                            value="{{ $school->phone_number }}" class="form-control" id="phone_number"
                                            required>
                                        @error('phone_number')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="email">Email</label><span class="must"> *</span>
                                            <input type="email" class="form-control" value="{{ $school->email }}"
                                                id="email" name="email">
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="emergency_contact">Emergency Contact</label>
                                            <input id="emergency_contact" type="text"
                                                value="{{ $school->emergency_contact }}" class="form-control"
                                                name="emergency_contact">
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <input id="website" type="text" value="{{ $school->website }}"
                                                class="form-control" name="website">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="established_date">Establishment Date</label>
                                            <input id="established_date" type="date" value="{{ $school->established_date }}"
                                                class="form-control" name="established_date">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <h5>School's Logo:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4 mb-4">
                                        @php
                                            $oldLogo = old('logo', $school->logo ?? '');
                                        @endphp
                                        <img src="{{ $oldLogo ? asset($oldLogo) : '' }}" id="image"
                                            style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control"
                                                placeholder="Image" name="logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="{{ $oldLogo ? '' : 'hidden' }}">
                                            <br>
                                            <img id="croppedImagePreview" height="150"
                                                src="{{ $oldLogo ? asset($oldLogo) : '' }}"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic"
                                                tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage"
                                                style="margin-top: 7px;">Remove</button>
                                        </div>
                                        {{-- Add a hidden field to retain the existing logo path --}}
                                        <input type="hidden" name="old_logo" value="{{ $oldLogo }}">
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5>School's Status:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="col-sm-10">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_active" id="option1"
                                                    value="1" autocomplete="off" checked="">
                                                <label class="btn btn-secondary" for="option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_active" id="option2"
                                                    value="0" autocomplete="off">
                                                <label class="btn btn-secondary" for="option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5>School's Additional Information</h5>
                                    <div class="hr-line-dashed"></div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input id="bank_name" type="text" value="{{ $school->bank_name }}"
                                                class="form-control" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="bank_account_no">Bank Account Number</label>
                                            <input id="bank_account_no" type="text"
                                                value="{{ $school->bank_account_no }}" class="form-control"
                                                name="bank_account_no">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="bank_branch">Bank Branch</label>
                                            <input id="bank_branch" type="text" value="{{ $school->bank_branch }}"
                                                class="form-control" name="bank_branch">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="disable_reason">Reason to Disable</label>
                                            <input id="disable_reason" type="text"
                                                value="{{ $school->disable_reason }}" class="form-control"
                                                name="disable_reason">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="facebook">Facebook Link</label>
                                            <input id="facebook" type="text" value="{{ $school->facebook }}"
                                                class="form-control" name="facebook">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="twitter">Twitter Link</label>
                                            <input id="twitter" type="text" value="{{ $school->twitter }}"
                                                class="form-control" name="twitter">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="linkedin">LinkedIn Link</label>
                                            <input id="linkedin" type="text" value="{{ $school->linkedin }}"
                                                class="form-control" name="linkedin">
                                        </div>
                                    </div>
                                    <div class="col-lg-4  mt-2">
                                        <div class="form-group">
                                            <label for="instagram">Instagram Link</label>
                                            <input id="instagram" type="text" value="{{ $school->instagram }}"
                                                class="form-control" name="instagram">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="disable_at">Disable At</label>
                                            <input id="disable_at" type="text" value="{{ $school->disable_at }}"
                                                class="form-control" name="disable_at">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea id="note" type="text" value="" class="form-control" name="note">
                                                {{ $school->note }}
                                            </textarea>
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
                // Retrieve and log the data attribute value
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
                var append_to = 'municipalitiy_id';
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

            $(document).on('change', '.municipality_id', function() {
                var municipality_id = $(this).val();
                var append_to = 'ward_id';
                $.ajax({
                    url: '/admin/get-ward-by-municipality/' + municipality_id,
                    type: 'GET',
                    success: function(response) {
                        var clearThisData = $('#' + append_to + '').empty();
                        if (response.length > 0) {
                            $('#' + append_to + '').append(
                                '<option disabled selected value>Choose Ward</option>');
                            $.each(response, function(key, value) {
                                $('#' + append_to + '').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#' + append_to + '').append(
                                '<option value="">No wards found</option>');
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
