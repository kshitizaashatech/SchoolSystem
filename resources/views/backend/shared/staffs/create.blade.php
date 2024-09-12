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
            @include('backend.shared.staffs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="">
                        <div class="">
                            <form id="regForm" method="POST" action="{{ route('admin.staffs.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <!--This indicates the steps of the form: -->
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Bank/Social Information</span>
                                    
                                    {{-- INCASE ADDED STEPS ARE NEEDED --}}
                                    {{-- <span class="step"></span> --}}
                                </div>

                                <div class="tab">

                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">

                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="state_id">Choose State <span class="must"> *</span></label>
                                                <div class="select">
                                                    <select id="state_id" name="state_id" data-iteration="0"
                                                        class="state_id" required>
                                                        <option disabled value="">Choose State</option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ $adminStateId == $state->id ? 'selected' : '' }}>
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
                                                <label for="district_id">Choose District <span class="must">
                                                        *</span></label>

                                                <div class="select">

                                                    <select id="district_id" name="district_id" data-iteration="0"
                                                        class="district_id" required>
                                                        {{-- <option value="{{ old('district_id') }}">Choose District</option> --}}
                                                        <option value="{{ $adminDistrictId }}" selected>
                                                            {{ Auth::user()->district->name }}</option>
                                                    </select>
                                                </div>
                                                @error('district_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="municipalitiy_id">Choose Municipality <span class="must">
                                                        *</span></label>

                                                <div class="select">

                                                    <select id="municipalitiy_id" name="municipality_id" data-iteration="0"
                                                        class="municipality_id" required>
                                                        <option value="{{ $adminMunicipalityId }}" selected>
                                                            {{ Auth::user()->municipality->name }}</option>
                                                    </select>
                                                </div>
                                                @error('municipalitiy_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="">
                                                <label for="ward_id">Choose Ward <span class="must"> *</span></label>
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

                                    </div>



                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Staff's Basic Information:</h5>
                                        <div class="hr-line-dashed"></div>

                                        <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">

                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="f_name">First Name: <span class="must"> *</span></label>
                                                <input type="text" name="f_name" value="{{ old('f_name') }}"
                                                    class="form-control" id="f_name" placeholder="Enter First Name">
                                                @error('f_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="m_name">Middle Name:</label>
                                                <input type="text" name="m_name" value="{{ old('m_name') }}"
                                                    class="form-control" id="m_name" placeholder="Enter Middle Name">
                                                @error('m_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="l_name">Last Name: <span class="must"> *</span> </label>
                                                <input type="text" name="l_name" value="{{ old('l_name') }}"
                                                    class="form-control" id="l_name" placeholder="Enter Last Name">
                                                @error('l_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="email">Email: <span class="must"> *</span></label>
                                                <input type="text" name="email" value="{{ old('email') }}"
                                                    class="form-control" id="email" placeholder="Enter Email">
                                                @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mobile_number">Mobile No. : <span class="must">
                                                        *</span></label>
                                                <input type="text" name="mobile_number"
                                                    value="{{ old('mobile_number') }}" class="form-control"
                                                    id="mobile_number" placeholder="Enter Mobile Number">
                                                @error('mobile_number')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="phone">Gender: <span class="must"> *</span></label><br>
                                            
                                                <label for="gender_male" class="l-radio">
                                                    <input type="radio" name="gender" value="Male" id="gender_male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                                    <span>Male</span>
                                                </label>
                                            
                                                <label for="gender_female" class="l-radio">
                                                    <input type="radio" name="gender" value="Female" id="gender_female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                                    <span>Female</span>
                                                </label>
                                            
                                                @error('gender')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            


                                            <div class="col-lg-3 col-md-3">
                                                <label for="datetimepicker">Date of Birth:</label>
                                                <div class="form-group">
                                                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                                        <input id="nepali-datepicker" name="dob" type="text" class="form-control datetimepicker-input" value="{{ old('dob') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <form id="employee-form" method="POST" action="/your-form-action">
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="employee_id">Employee Id: <span class="must">*</span></label>
                                                    <input type="text" name="employee_id" class="form-control" id="employee_id" placeholder="Enter Employee Id" >
                                                    @error('employee_id')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>


                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Staff's Picture:</h5>
                                        <div class="hr-line-dashed"></div>
                                        <div class="col-lg-4">
                                            <img src="" id="image" style="width: 20%;">
                                            <div class="form-group">
                                                <input type="file" id="imageFile" class="form-control"
                                                    placeholder="Image" name="image" data-ratio="16"
                                                    data-ratiowidth="16">
                                            </div>
                                            <div id="previewWrapper" class="hidden">
                                                <br>
                                                <img id="croppedImagePreview" height="150"><br>
                                                <input type="hidden" name="inputCroppedPic" id="inputCroppedPic"
                                                    tabindex="-1">
                                                <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                    type="button" id="removeCroppedImage"
                                                    style="margin-top: 7px;">Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Staff's Location Information:</h5>


                                    <div class="col-md-12 col-lg-12 d-flex gap-2 justify-content-between">

                                        <div class=" col-lg-3 col-sm-3">
                                            <label for="local_address">Local Address: <span class="must">
                                                    *</span></label>
                                            <input type="text" name="local_address"
                                                value="{{ old('local_address') }}" class="form-control"
                                                id="local_address" placeholder="Enter Local Address">
                                            @error('local_address')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3">
                                            <label for="permanent_address">Permanent Address: <span class="must">
                                                    *</span></label>
                                            <input type="text" name="permanent_address"
                                                value="{{ old('permanent_address') }}" class="form-control"
                                                id="permanent_address" placeholder="Enter Permanent Address">
                                            @error('permanent_address')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>


                                        <!-- Role Dropdown -->
                                        {{-- <div class="form-group">
                                        <label for="role">Select Role:</label>
                                        <select name="role" id="role" class="form-control">
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group col-lg-3 col-sm-3">
                                        <label for="role">Select Role: <span class="must"> *</span></label>
                                        <div class="select">
                                            <select name="role" id="role" class="role_id selectpicker" data-live-search="true" title="Choose Role" required>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    

                                    </div>

                                    <div class="form-group col-lg-3 col-sm-3 mt-4">
                                        <label for="active">Status:</label>
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


                                <div class="tab">

                                    <div class="col-lg-12 col-md-12 d-flex flex-wrap mt-4">
                                        <div class="col-lg-12 col-md-12">

                                            <div class="hr-line-dashed"></div>
                                            <h5>Staff's Bank Information:</h5>
                                            <div class="hr-line-dashed"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_name">Bank's Name:</label>
                                                <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                                    class="form-control" id="bank_name" placeholder="Enter Bank's Name">
                                                @error('bank_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_account_no">Bank Acc. Number:</label>
                                                <input type="text" name="bank_account_no"
                                                    value="{{ old('bank_account_no') }}" class="form-control"
                                                    id="bank_account_no" placeholder="Enter Bank's Account Number">
                                                @error('bank_account_no')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_branch">Bank Branch:</label>
                                                <input type="text" name="bank_branch"
                                                    value="{{ old('bank_branch') }}" class="form-control"
                                                    id="bank_branch" placeholder="Enter Bank's Branch">
                                                @error('bank_branch')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="hr-line-dashed"></div>
                                    <h5>Staff's Social Information:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                        {{-- <div class="form-group col-lg-3 col-sm-3 mt-2">
                                        <label for="username">Username:</label>
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            class="form-control" id="username" placeholder="Enter Username">
                                        @error('username')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div> --}}
                                        {{-- <div class="form-group col-lg-3 col-sm-3 mt-2">
                                        <label for="password">Password:</label>
                                        <input type="text" name="password" value="{{ old('password') }}"
                                            class="form-control" id="password" placeholder="Enter Password">
                                        @error('password')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-log-3 col-sm-3 mt-2">
                                        <label for="password">Password Confirmation</label>
                                        <input id="password-confirm" type="password"
                                            value="{{ old('password_confirmation') }}"
                                            placeholder="Confirm Password" class="form-control"
                                            name="password_confirmation">
                                    </div> --}}
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="facebook">Facebook:</label>
                                            <input type="text" name="facebook" value="{{ old('facebook') }}"
                                                class="form-control" id="facebook"
                                                placeholder="Enter Facebook Profile URL">
                                            @error('facebook')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="twitter">Twitter:</label>
                                            <input type="text" name="twitter" value="{{ old('twitter') }}"
                                                class="form-control" id="twitter"
                                                placeholder="Enter Twitter Profile URL">
                                            @error('twitter')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="linkedin">LinkedIn:</label>
                                            <input type="text" name="linkedin" value="{{ old('linkedin') }}"
                                                class="form-control" id="linkedin"
                                                placeholder="Enter LinkedIn Profile URL">
                                            @error('linkedin')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="instagram">Instagram:</label>
                                            <input type="text" name="instagram" value="{{ old('instagram') }}"
                                                class="form-control" id="instagram"
                                                placeholder="Enter Instagram Profile URL">
                                            @error('linkedin')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5 class="">Other Basic Information</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="blood_group">Blood Group:</label>
                                            <input type="text" name="blood_group" value="{{ old('blood_group') }}"
                                                class="form-control" id="blood_group" placeholder="Enter Blood Group">
                                            @error('blood_group')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="religion">Religion:</label>
                                            <input type="text" name="religion" value="{{ old('religion') }}"
                                                class="form-control" id="religion" placeholder="Enter Religion">
                                            @error('religion')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5 class="">Other Information</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">



                                        <div class="col-lg-3 col-md-3">
                                            <label for="datetimepicker">Date of Joining:</label>
                                            <div class="form-group">
                                                <div class="input-group date" id="datetimepicker"
                                                    data-target-input="nearest">
                                                    <input id="datetimepickerjoining" name="date_of_joining"
                                                        type="text" class="form-control datetimepicker-input" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="payscale">Payscale</label>
                                            <input type="text" name="payscale" value="{{ old('payscale') }}"
                                                class="form-control" id="payscale" placeholder="Enter Payscale"
                                                required>
                                            @error('payscale')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="basic_salary">Basic Salary</label>
                                            <input type="text" name="basic_salary" value="{{ old('basic_salary') }}"
                                                class="form-control" id="basic_salary" placeholder="Enter Basic Salary"
                                                required>
                                            @error('basic_salary')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-sm-3">
                                            <label for="contract_type">Contract Type</label>
                                            <input type="text" name="contract_type"
                                                value="{{ old('contract_type') }}" class="form-control"
                                                id="contract_type" placeholder="Enter Contract type" required>
                                            @error('contract_type')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="shift">shift</label>
                                            <input type="text" name="shift" value="{{ old('shift') }}"
                                                class="form-control" id="shift" placeholder="Enter Shift" required>
                                            @error('shift')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="joining_letter">Joining Letter</label>
                                            <input type="text" name="joining_letter"
                                                value="{{ old('joining_letter') }}" class="form-control"
                                                id="joining_letter" placeholder="Enter joining_letter" required>
                                            @error('joining_letter')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-sm-3">
                                            <label for="other_document">Other Document</label>
                                            <input type="text" name="other_document"
                                                value="{{ old('other_document') }}" class="form-control"
                                                id="other_document" placeholder="Enter other_document" required>
                                            @error('other_document')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="resume">Resume :</label>
                                            <input type="file" name="resume" class="form-control" id="pdf"
                                                accept=".pdf">
                                            @error('resume')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-sm-3">
                                        <label for="qualification"> Qualification:</label>
                                        <input type="text" name="qualification" value="{{ old('qualification') }}"
                                            class="form-control" id="qualification" placeholder="Enter Qualification">
                                        @error('qualification')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="work_experience"> Work Experience:</label>
                                        <input type="text" name="work_experience"
                                            value="{{ old('work_experience') }}" class="form-control"
                                            id="work_experience" placeholder="Enter Work Experience">
                                        @error('work_experience')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <!-- Department Dropdown -->
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="department_id">Select Department:</label>
                                        <div class="select">
                                            <select name="department_id" id="department_id" class="">
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3 col-sm-3">
                                        <label for="marital_status">Marital Status:</label>
                                        <div class="btn-group">
                                            <div class="col-sm-10">
                                                <input type="radio" class="btn-check" name="marital_status" id="married"
                                                    value="1" autocomplete="off" checked>
                                                <label class="btn btn-secondary" for="married">Married</label>

                                                <input type="radio" class="btn-check" name="marital_status"
                                                    id="unmarried" value="0" autocomplete="off">
                                                <label class="btn btn-secondary" for="unmarried">Unmarried</label>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-group col-lg-3 col-sm-3 mt-2">
                                        <label for="marital_status">Maritial Status:</label><br>

                                        <label for="married" class="l-radio">
                                            <input type="radio" name="marital_status" value="1" id="married">
                                            <span>Married</span>
                                        </label>

                                        <label for="unmarried" class="l-radio">
                                            <input type="radio" name="marital_status" value="0" id="unmarried">
                                            <span>Unmarried</span>
                                        </label>


                                        @error('marital_status')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                {{-- </div>

                                <div class="tab">

                                    <div class="hr-line-dashed"></div>
                                    <h5>Leave Detail:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">

                                        <div class="col-lg-3 col-sm-3">
                                            <label for="medical_leave">Medical Leave</label>
                                            <input type="text" name="medical_leave"
                                                value="{{ old('medical_leave') }}" class="form-control"
                                                id="medical_leave" placeholder="Enter medical_leave" required>
                                            @error('medical_leave')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="casual_leave">Casual Leave</label>
                                            <input type="text" name="casual_leave" value="{{ old('casual_leave') }}"
                                                class="form-control" id="casual_leave" placeholder="Enter casual_leave"
                                                required>
                                            @error('casual_leave')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="maternity_leave">Maternity Leave</label>
                                            <input type="text" name="maternity_leave"
                                                value="{{ old('maternity_leave') }}" class="form-control"
                                                id="maternity_leave" placeholder="Enter maternity_leave" required>
                                            @error('maternity_leave')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="hr-line-dashed"></div>
                                    <h5>Leaving Detail:</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">


                                        {{-- <div class="form-group col-lg-4 col-sm-4">
                                        <label for="datetimepicker">Date of Leaving:</label>
                                        <div class="form-group">
                                            <div class="input-group date" id="datetimepicker"
                                                data-target-input="nearest">
                                                <input id="nepali-datepicker" name="date_of_leaving" type="text"
                                                    class="form-control datetimepicker-input" />
                                            </div>
                                        </div>
                                    </div> --}}

                                        {{-- <div class="form-group col-lg-4 col-sm-4">
                                            <label for="datetimepicker">Date of Leaving:</label>
                                            <div class="form-group">
                                                <div class="input-group date" id="datetimepicker"
                                                    data-target-input="nearest">
                                                    <input id="nepali-datepicker2" name="date_of_leaving" type="text"
                                                        class="form-control datetimepicker-input" />
                                                </div>
                                            </div>
                                        </div> --}}


                                        {{-- <div class="form-group col-lg-4 col-sm-4">
                                            <label for="resignation_letter">Resignation Letter</label>
                                            <input type="text" name="resignation_letter"
                                                value="{{ old('resignation_letter') }}" class="form-control"
                                                id="resignation_letter" placeholder="Enter resignation_letter" required>
                                            @error('resignation_letter')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="note">Note :</label>
                                            <textarea name="note" class="form-control" id="note" placeholder="Note.." rows="15" cols="50">
                                                        {{ old('note') }}
                                                    </textarea>

                                            @error('note')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div> --}}

                                    </div>
                                </div> 

                                <div class=" d-flex justify-content-end mt-4">
                                    <div style="">
                                        <button class="btn btn-secondary" type="button" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button class="btn btn-primary" type="button" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>
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
    @include('backend.includes.nepalidate')
    @include('backend.includes.cropperjs')

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            if (currentTab >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            // for (i = 0; i < y.length; i++) {
            //     // If a field is empty...
            //     if (y[i].value == "") {
            //         // add an "invalid" class to the field:
            //         y[i].className += " invalid";
            //         // and set the current valid status to false:
            //         valid = false;
            //     }
            // }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script>


    {{-- <script>
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
</script> --}}

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

     // Function to generate a random 3-digit number
  function generateRandomNumber() {
        const length = 3;
        const chars = '123456789';
        let randomNumber = '';
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * chars.length);
            randomNumber += chars[randomIndex];
        }
        return randomNumber;
    }

    // Function to generate the employee id based on municipality ID and school ID
    function generateEmployeeId(municipalityId, schoolId) {
        const randomNumber = generateRandomNumber();
        return `${municipalityId}${schoolId}${randomNumber}`;
    }

    // Set the generated employee id to the input field
    function updateEmployeeId() {
        const employeeIdInput = document.getElementById('employee_id');
        const municipalityId = document.getElementById('municipalitiy_id').value;
        const schoolId = "{{ $schoolId }}"; // Retrieve school ID from the Blade template
        if (employeeIdInput) {
            employeeIdInput.value = generateEmployeeId(municipalityId, schoolId);
        }
    }

    // Event listener for DOM content loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Update employee id on page load if not set
        const employeeIdInput = document.getElementById('employee_id');
        if (employeeIdInput && !employeeIdInput.value) {
            updateEmployeeId();
        }

        // Update employee id when municipality selection changes
        const municipalitySelect = document.getElementById('municipalitiy_id');
        if (municipalitySelect) {
            municipalitySelect.addEventListener('change', updateEmployeeId);
        }
    });


</script>


    </script>

@endsection


