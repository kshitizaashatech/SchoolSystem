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
                                action="{{ route('admin.schools.store') }}" enctype="multipart/form-data">
                                @csrf
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
                                                    <option disabled selected value="{{ old('state_id') }}">Choose State
                                                    </option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}"
                                                            {{ $adminStateId == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}</option>
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
                                                    <option value="{{ $adminDistrictId }}" selected>
                                                        {{ Auth::user()->district ?? (Auth::user()->district ? Auth::user()->district->name : '') }}</option>
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
                                                    <option value="{{ $adminMunicipalityId }}" selected>
                                                        {{ Auth::user()->municipality ?? (Auth::user()->municipality ? Auth::user()->municipality->name : '') }}</option>
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
                                    {{-- <div class="d-flex col-md-12 gap-1">

                                        <div class="form-group col-lg-2 col-sm-2">
                                            <label for="school_type">School Type</label><span class="must"> *</span>
                                            <div class="select">
                                                <select name="school_type" id="school_type">
                                                    <option value="pre-primary">Pre Primary</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="lower-secondary">Lower Secondary</option>
                                                    <option value="secondary">Secondary</option>
                                                    <option value="higher-secondary">Higher Secondary</option>
                                                </select>
                                            </div>
                                            @error('school_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-2 col-sm-2">
                                            <label for="school_code">School Code</label><span class="must"> *</span>
                                            <input type="text" name="school_code" value="{{ old('school_code') }}"
                                                class="form-control" id="school_code" placeholder="Enter School Code"
                                                required>
                                            @error('school_code')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-2 col-sm-2">
                                            <label for="head_teacher">Head Teacher</label><span class="must"> *</span>
                                            <input type="text" name="head_teacher" value="{{ old('head_teacher') }}"
                                                class="form-control" id="head_teacher" placeholder="Enter Head Teacher Name"
                                                required>
                                            @error('head_teacher')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>


                                    </div> --}}
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                                            <label for="school_type">School Type</label><span class="must"> *</span>
                                            <div class="select">
                                                <select name="school_type" id="school_type" class="">
                                                    <option value="pre-primary">Pre Primary</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="lower-secondary">Lower Secondary</option>
                                                    <option value="secondary">Secondary</option>
                                                    <option value="higher-secondary">Higher Secondary</option>
                                                </select>
                                            </div>
                                            @error('school_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                                            <label for="school_code">School Code</label><span class="must"> *</span>
                                            <input type="text" name="school_code" value="{{ old('school_code') }}"
                                                class="form-control" id="school_code" placeholder="Enter School Code"
                                                required>
                                            @error('school_code')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                                            <label for="head_teacher">Head Teacher</label><span class="must"> *</span>
                                            <input type="text" name="head_teacher" value="{{ old('head_teacher') }}"
                                                class="form-control" id="head_teacher" placeholder="Enter Head Teacher Name"
                                                required>
                                            @error('head_teacher')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="name">Name</label><span class="must"> *</span>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" id="name" placeholder="Enter School Name" required>
                                        @error('name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="address">Address</label><span class="must"> *</span>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ old('address') }}" id="address" placeholder="Enter Address"
                                            required>
                                        @error('address')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="phone_number">Phone No</label><span class="must"> *</span>
                                        <input type="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            class="form-control" id="phone_number" placeholder="Enter Phone" required>
                                        @error('phone_number')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="email">Email</label><span class="must"> *</span>
                                            <input type="email" class="form-control" value="{{ old('email') }}"
                                                id="email" name="email" placeholder="Enter Email" value="">
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="emergency_contact">Emergency Contact</label>
                                            <input id="emergency_contact" type="text"
                                                value="{{ old('emergency_contact') }}" placeholder="Emergency Contact"
                                                class="form-control" name="emergency_contact">
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <input id="website" type="text" value="{{ old('website') }}"
                                                placeholder="Website URL" class="form-control" name="website">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="established_date">Establishment Date</label>
                                            <input id="established_date" type="date" value="{{ old('established_date') }}"
                                                placeholder="Establishment Date" class="form-control" name="established_date">
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5>Schools's Logo:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4 mb-4">
                                        <img src="" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control"
                                                placeholder="Image" name="logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePreview" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic"
                                                tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <h5>School's Status:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4">
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
                                    <h5>School's Additional Information:</h5>
                                    <div class="hr-line-dashed"></div>

                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input id="bank_name" type="text" value="{{ old('bank_name') }}"
                                                placeholder="Bank Name" class="form-control" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="bank_account_no">Bank Account Number</label>
                                            <input id="bank_account_no" type="text"
                                                value="{{ old('bank_account_no') }}" placeholder="Bank Account Number"
                                                class="form-control" name="bank_account_no">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="bank_branch">Bank Branch</label>
                                            <input id="bank_branch" type="text" value="{{ old('bank_branch') }}"
                                                placeholder="Bank Branch" class="form-control" name="bank_branch">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="disable_reason">Reason to Disable</label>
                                            <input id="disable_reason" type="text"
                                                value="{{ old('disable_reason') }}" placeholder="Disable Reason"
                                                class="form-control" name="disable_reason">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="facebook">Facebook Link</label>
                                            <input id="facebook" type="text" value="{{ old('facebook') }}"
                                                placeholder="Facebook URL" class="form-control" name="facebook">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="twitter">Twitter Link</label>
                                            <input id="twitter" type="text" value="{{ old('twitter') }}"
                                                placeholder="Twitter URL" class="form-control" name="twitter">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="linkedin">LinkedIn Link</label>
                                            <input id="linkedin" type="text" value="{{ old('linkedin') }}"
                                                placeholder="LinkedIn URL" class="form-control" name="linkedin">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="instagram">Instagram Link</label>
                                            <input id="instagram" type="text" value="{{ old('instagram') }}"
                                                placeholder="Instagram URL" class="form-control" name="instagram">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="disable_at">Disable At</label>
                                            <input id="disable_at" type="text" value="{{ old('disable_at') }}"
                                                placeholder="Disabled At" class="form-control" name="disable_at">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea id="note" value="{{ old('note') }}" class="form-control" name="note">
                                            </textarea>
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
            var preselectedStateId = '{{ $adminStateId }}';
            var preselectedDistrictId = '{{ $adminDistrictId }}';
            var preselectedMunicipalityId = '{{ $adminMunicipalityId }}';

            // Function to load districts
            function loadDistricts(state_id, district_id = null) {
                var append_to = 'district_id';
                $.ajax({
                    url: '/admin/get-district-by-state/' + state_id,
                    type: 'GET',
                    success: function(response) {
                        var options = '<option disabled value>Choose District</option>';
                        response.forEach(function(district) {
                            options +=
                                `<option value="${district.id}" ${district_id == district.id ? 'selected' : ''}>${district.name}</option>`;
                        });
                        $('#' + append_to).html(options);

                        // Load municipalities for the preselected or first loaded district
                        if (district_id) {
                            loadMunicipalities(district_id, preselectedMunicipalityId);
                        } else if (response.length > 0) {
                            loadMunicipalities(response[0].id);
                        }
                    },
                    error: function() {
                        console.log("error in the ajax");
                        $('#' + append_to).html('<option value="">No districts found</option>');
                    }
                });
            }

            // Function to load municipalities
            function loadMunicipalities(district_id, municipality_id = null) {
                var append_to = 'municipalitiy_id'; // Ensure this ID matches your select ID
                $.ajax({
                    url: '/admin/get-municipality-by-district/' + district_id,
                    type: 'GET',
                    success: function(response) {
                        var options = '<option disabled selected value>Choose Municipality</option>';
                        response.forEach(function(municipality) {
                            options +=
                                `<option value="${municipality.id}" ${municipality_id == municipality.id ? 'selected' : ''}>${municipality.name}</option>`;
                        });
                        $('#' + append_to).html(options);

                        // Load wards for the preselected or first loaded municipality
                        if (municipality_id) {
                            loadWards(municipality_id);
                        } else if (response.length > 0) {
                            loadWards(response[0].id);
                        }
                    },
                    error: function() {
                        console.log("error in the ajax");
                        $('#' + append_to).html('<option value="">No municipalities found</option>');
                    }
                });
            }

            // Function to load wards
            function loadWards(municipality_id) {
                var append_to = 'ward_id'; // Ensure this ID matches your select ID for wards
                $.ajax({
                    url: '/admin/get-ward-by-municipality/' + municipality_id,
                    type: 'GET',
                    success: function(response) {
                        var options = '<option disabled selected value>Choose Ward</option>';
                        response.forEach(function(ward) {
                            options += `<option value="${ward.id}">${ward.name}</option>`;
                        });
                        $('#' + append_to).html(options);
                    },
                    error: function() {
                        console.log("error in the ajax");
                        $('#' + append_to).html('<option value="">No wards found</option>');
                    }
                });
            }

            // Listen for state changes to reload districts
            $(document).on('change', '.state_id', function() {
                var state_id = $(this).val();
                loadDistricts(state_id);
            });

            // Listen for district changes to reload municipalities
            $(document).on('change', '.district_id', function() {
                var district_id = $(this).val();
                loadMunicipalities(district_id);
            });

            // Listen for municipality changes to reload wards
            $(document).on('change', '.municipality_id', function() {
                var municipality_id = $(this).val();
                loadWards(municipality_id);
            });

            // Preload districts, municipalities, and wards if there are preselected values
            if (preselectedStateId) {
                loadDistricts(preselectedStateId, preselectedDistrictId);
            }
        });


    // Function to generate school code

    function generateSchoolCode(districtId, municipalityId) {
    const codeLength = 3;
    const chars = '0123456789';
    let serialNumber = '';

    for (let i = 0; i < codeLength; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        serialNumber += chars[randomIndex];
    }

    return `${districtId}${municipalityId}${serialNumber}`;
}

    // Function to update school code based on dropdown selections

    function updateSchoolCode() {
    const districtSelect = document.getElementById('district_id');
    const municipalitySelect = document.getElementById('municipalitiy_id');
    const schoolCodeInput = document.getElementById('school_code');

    const districtId = districtSelect.value;
    const municipalityId = municipalitySelect.value;

    if (districtId && municipalityId) {
        schoolCodeInput.value = generateSchoolCode(districtId, municipalityId);
    } else {
        schoolCodeInput.value = ''; // Clear the input if both dropdowns are not selected
    }
}

    // Add event listeners to dropdowns

    document.getElementById('district_id').addEventListener('change', updateSchoolCode);
    document.getElementById('municipalitiy_id').addEventListener('change', updateSchoolCode);

    // Initialize school code on page load if both dropdowns have values

    document.addEventListener('DOMContentLoaded', function () {
    updateSchoolCode();
});
                                       
    </script>
@endsection
