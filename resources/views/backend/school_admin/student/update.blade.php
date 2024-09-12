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
            @include('backend.school_admin.student.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="">
                        <div class="">
                            <form id="regForm" action="{{ route('admin.students.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!--This indicates the steps of the form: -->
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Parent/Guardian Information</span>
                                    <span class="step">Social Information</span>
                                    {{-- INCASE ADDED STEPS ARE NEEDED --}}
                                    {{-- <span class="step"></span> --}}
                                </div>
                                <div class="tab">

                                    <div class="hr-line-dashed"></div>
                                    <h5 class="">Student's Admission Information</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-between">
                                        <div class=" col-lg-3 col-sm-3">
                                            <label for="admission_no"> Admission Number:</label>
                                            <input type="text" name="admission_no"
                                                value="{{ old('admission_no', $student->admission_no) }}"
                                                class="form-control" id="admission_no" placeholder="Enter Admission Number">
                                            @error('admission_no')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <label for="datetimepicker">Admission Date:</label>
                                            <div class="form-group">
                                                <div class="input-group date" id="datetimepicker"
                                                    data-target-input="nearest">
                                                    <input id="admission-datepicker"
                                                        value="{{ old('admission_date', $student->admission_date) }}"
                                                        name="admission_date" type="text"
                                                        class="form-control datetimepicker-input" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col-lg-3 col-sm-3">
                                            <label for="roll_no"> Roll Number:</label>
                                            <input type="text" name="roll_no"
                                                value="{{ old('roll_no', $student->roll_no) }}" class="form-control"
                                                id="roll_no" placeholder="Enter Roll Number">
                                            @error('roll_no')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-between">
                                        <div class=" col-lg-3 col-sm-3 mt-2">
                                            <label for="class_id"> Class:</label>
                                            <div class="select">
                                                <select name="class_id">
                                                    <option value="" disabled>Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                            {{ $class->class }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('class_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class=" col-lg-3 col-sm-3 mt-2">
                                            <label for="section_id"> Section:</label>
                                            <div class="select">
                                                <select name="section_id">
                                                    <option disabled selected>Select Section</option>
                                                    @foreach ($sections as $sectionId => $sectionName)
                                                        <option value="{{ $sectionId }}"
                                                            {{ old('section_id', $student->section_id) == $sectionId ? 'selected' : '' }}>
                                                            {{ $sectionName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('class_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class=" col-lg-3 col-sm-3 mt-2">
                                            <label for="school_house_id"> School House:</label>
                                            <div class="select">
                                                <select name="school_house_id">
                                                    <option disabled>Select School House</option>
                                                    @foreach ($school_houses as $house)
                                                        <option value="{{ $house->id }}"
                                                            {{ old('school_house_id', $house->id) == $house->id ? 'selected' : '' }}>
                                                            {{ $house->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('class_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed mt-4"></div>
                                    <h5 class="">Student's Location Information:</h5>

                                    <div class="hr-line-dashed"></div>
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-around">

                                        <div class="col-md-6 col-lg-6 col-sm-6 pt-4 pb-4 d-flex  gap-3">
                                            <div class="">
                                                <label for="state_id">Choose State</label>
                                                <div class="select">
                                                    <select name="state_id" id="state_id" data-iteration="0"
                                                        class="state_id">
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id', $student->user->state_id) == $state->id ? 'selected' : '' }}>
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
                                                <label for="district_id">Choose District</label>

                                                <div class="select">

                                                    <select id="district_id" name="district_id" data-iteration="0"
                                                        class="district_id" required>
                                                        <option disabled selected value>Choose District</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ old('district_id', $student->user->district_id) == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
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
                                                <label for="municipalitiy_id">Choose Municipality</label>

                                                <div class="select">

                                                    <select id="municipalitiy_id" name="municipality_id" data-iteration="0"
                                                        class="municipality_id" required>
                                                        <option value="">Choose Municipality</option>
                                                        @foreach ($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                {{ old('municipality_id', $student->user->municipality_id) == $municipality->id ? 'selected' : '' }}>
                                                                {{ $municipality->name }}
                                                            </option>
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
                                                <label for="ward_id">Choose Ward</label>
                                                <div class="select">

                                                    <select id="ward_id" name="ward_id" data-iteration="0"
                                                        class="ward_id" required>
                                                        <option value="">Choose Ward</option>
                                                        @foreach ($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                                {{ old('ward_id', $student->user->ward_id) == $ward->id ? 'selected' : '' }}>
                                                                {{ $ward->name }}
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

                                    </div>
                                    <div class="col-md-12 col-lg-12 d-flex gap-2 justify-content-between">

                                        <div class=" col-lg-4 col-sm-4">
                                            <label for="local_address">Local Address:</label>
                                            <input type="text" name="local_address"
                                                value="{{ old('local_address', $student->user->local_address) }}"
                                                class="form-control" id="local_address"
                                                placeholder="Enter Local Address">
                                            @error('local_address')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="permanent_address">Permanent Address:</label>
                                            <input type="text" name="permanent_address"
                                                value="{{ old('permanent_address', $student->user->permanent_address) }}"
                                                class="form-control" id="permanent_address"
                                                placeholder="Enter Permanent Address">
                                            @error('permanent_address')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>


                                    </div>

                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Basic Information:</h5>
                                        <div class="hr-line-dashed"></div>

                                        <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">

                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="f_name">First Name:</label>
                                                <input type="text" name="f_name"
                                                    value="{{ old('f_name', $student->user->f_name) }}"
                                                    class="form-control" id="f_name" placeholder="Enter First Name">
                                                @error('f_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="m_name">Middle Name:</label>
                                                <input type="text" name="m_name"
                                                    value="{{ old('m_name', $student->user->m_name) }}"
                                                    class="form-control" id="m_name" placeholder="Enter Middle Name">
                                                @error('m_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3">
                                                <label for="l_name">Last Name </label>
                                                <input type="text" name="l_name"
                                                    value="{{ old('l_name', $student->user->l_name) }}"
                                                    class="form-control" id="l_name" placeholder="Enter Last Name">
                                                @error('l_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="email">Email:</label>
                                                <input type="text" name="email"
                                                    value="{{ old('email', $student->user->email) }}"
                                                    class="form-control" id="email" placeholder="Enter Email">
                                                @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="religion">Religion:</label>
                                                <input type="text" name="religion"
                                                    value="{{ old('religion', $student->user->religion) }}"
                                                    class="form-control" id="religion" placeholder="Enter Religion">
                                                @error('religion')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mobile_number">Mobile No. :</label>
                                                <input type="text" name="mobile_number"
                                                    value="{{ old('mobile_number', $student->user->mobile_number) }}"
                                                    class="form-control" id="mobile_number"
                                                    placeholder="Enter Mobile Number">
                                                @error('mobile_number')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="phone">Gender:</label><br>

                                                <label for="gender_male" class="l-radio">
                                                    <input type="radio" name="gender" value="Male" id="gender_male"
                                                        {{ old('gender', $student->user->gender) == 'Male' ? 'checked' : '' }}>
                                                    <span>Male</span>
                                                </label>

                                                <label for="gender_female" class="l-radio">
                                                    <input type="radio" name="gender" value="Female"
                                                        id="gender_female"
                                                        {{ old('gender', $student->user->gender) == 'Female' ? 'checked' : '' }}>
                                                    <span>Female</span>
                                                </label>

                                                {{-- <label for="gender_other" class="l-radio">
                                                    <input type="radio" name="gender" value="Other"
                                                        id="gender_other"
                                                        {{ old('gender', $student->user->gender) == 'Other' ? 'checked' : '' }}>
                                                    <span>Other</span>
                                                </label> --}}
                                                @error('gender')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="dob">Date of Birth:</label>
                                                <input type="text" name="dob"
                                                    value="{{ old('dob', $student->user->dob) }}" class="form-control"
                                                    id="dob-datepicker" placeholder="Enter DOB">
                                                @error('dob')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="blood_group">Blood Group:</label>
                                                <select name="blood_group"
                                                        class="form-control" id="blood_group">
                                                    <option value="">Select Blood Group</option>
                                                    @foreach($bloodGroups as $id => $type)
                                                        <option value="{{ $id }}" {{ old('blood_group', $student->user->blood_group) == $id ? 'selected' : '' }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('blood_group')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Picture:</h5>
                                        <div class="hr-line-dashed"></div>
                                        <div class="col-lg-4">
                                            @if ($student->user->image)
                                                <img src="{{ asset($student->user->image) }}" id="image"
                                                    style="width: 20%;">
                                            @else
                                                <img src="" id="image" style="width: 20%;">
                                            @endif
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
                                                    style="margin-top: 7px;">Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="tab">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Parent Information:</h5>
                                        <div class="hr-line-dashed"></div>

                                        <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">

                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="father_name">Father's Name:</label>
                                                <input type="text" name="father_name"
                                                    value="{{ old('father_name', $student->user->father_name) }}"
                                                    class="form-control" id="father_name"
                                                    placeholder="Enter Father's Name">
                                                @error('father_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="father_phone">Father's Phone:</label>
                                                <input type="text" name="father_phone"
                                                    value="{{ old('father_phone', $student->user->father_phone) }}"
                                                    class="form-control" id="father_phone"
                                                    placeholder="Enter Father's Phone">
                                                @error('father_phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="">Father's Occupation:</label>
                                                <input type="text" name="father_occupation"
                                                    value="{{ old('father_occupation', $student->user->father_occupation) }}"
                                                    class="form-control" id="father_occupation"
                                                    placeholder="Enter Father's Occupation">
                                                @error('father_occupation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_name">Mother's Name:</label>
                                                <input type="text" name="mother_name"
                                                    value="{{ old('mother_name', $student->user->mother_name) }}"
                                                    class="form-control" id="mother_name"
                                                    placeholder="Enter Mother's Name">
                                                @error('mother_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_phone">Mother's Phone:</label>
                                                <input type="text" name="mother_phone"
                                                    value="{{ old('mother_phone', $student->user->mother_phone) }}"
                                                    class="form-control" id="mother_phone"
                                                    placeholder="Enter Mother's Phone">
                                                @error('mother_phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="mother_occupation">Mother's Occupation:</label>
                                                <input type="text" name="mother_occupation"
                                                    value="{{ old('mother_occupation', $student->user->mother_occupation) }}"
                                                    class="form-control" id="mother_occupation"
                                                    placeholder="Enter Mother's Occupation">
                                                @error('mother_occupation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="emergency_contact_person">Emergency Contact Person:</label>
                                                <input type="text" name="emergency_contact_person"
                                                    value="{{ old('emergency_contact_person', $student->user->emergency_contact_person) }}"
                                                    class="form-control" id="emergency_contact_person"
                                                    placeholder="Enter Emergency Contact Person">
                                                @error('emergency_contact_person')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                                                <input type="text" name="emergency_contact_phone"
                                                    value="{{ old('emergency_contact_phone', $student->user->emergency_contact_phone) }}"
                                                    class="form-control" id="emergency_contact_phone"
                                                    placeholder="Enter Emergency Contact Number">
                                                @error('emergency_contact_phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="hr-line-dashed"></div>
                                            <h5>Student's Guardian Information:</h5>
                                            <div class="hr-line-dashed"></div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="guardian_is">Guardian Is:</label><br>

                                                    <label for="guardian_father" class="l-radio">
                                                        <input type="radio" name="guardian_is" value="father"
                                                            id="guardian_father" onchange="toggleGuardianFields()"
                                                            {{ old('guardian_is', $student->guardian_is) == 'father' ? 'checked' : '' }}>
                                                        <span>Father</span>
                                                    </label>

                                                    <label for="guardian_mother" class="l-radio">
                                                        <input type="radio" name="guardian_is" value="mother"
                                                            id="guardian_mother" onchange="toggleGuardianFields()"
                                                            {{ old('guardian_is', $student->guardian_is) == 'mother' ? 'checked' : '' }}>
                                                        <span>Mother</span>
                                                    </label>

                                                    <label for="guardian_other" class="l-radio">
                                                        <input type="radio" name="guardian_is" value="other"
                                                            id="guardian_other" onchange="toggleGuardianFields()"
                                                            {{ old('guardian_is', $student->guardian_is) == 'other' ? 'checked' : '' }}>
                                                        <span>Other</span>
                                                    </label>
                                                    @error('guardian_is')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12" id="otherGuardianFields"
                                                style="display: none;">
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="guardian_name">Guardian Name:</label>
                                                    <input type="text" name="guardian_name"
                                                        value="{{ old('guardian_name', $student->guardian_name) }}"
                                                        class="form-control" id="guardian_name"
                                                        placeholder="Enter Guardian Name">
                                                    @error('guardian_name')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="guardian_name">Guardian Phone:</label>
                                                    <input type="text" name="guardian_phone"
                                                        value="{{ old('guardian_phone', $student->guardian_phone) }}"
                                                        class="form-control" id="guardian_phone"
                                                        placeholder="Enter Guardian Phone">
                                                    @error('guardian_phone')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="guardian_name">Guardian Relation:</label>
                                                    <input type="text" name="guardian_relation"
                                                        value="{{ old('guardian_relation', $student->guardian_relation) }}"
                                                        class="form-control" id="guardian_relation"
                                                        placeholder="Enter Guardian Relation">
                                                    @error('guardian_relation')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="guardian_name">Guardian Email:</label>
                                                    <input type="text" name="guardian_email"
                                                        value="{{ old('guardian_email', $student->guardian_email) }}"
                                                        class="form-control" id="guardian_email"
                                                        placeholder="Enter Guardian Email">
                                                    @error('guardian_email')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                {{-- <div class="tab">

                                    <div class="col-lg-12 col-md-12 d-flex flex-wrap mt-4">
                                        <div class="col-lg-12 col-md-12">

                                            <div class="hr-line-dashed"></div>
                                            <h5>Student's Bank Information:</h5>
                                            <div class="hr-line-dashed"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_name">Bank's Name:</label>
                                                <input type="text" name="bank_name"
                                                    value="{{ old('bank_name', $student->user->bank_name) }}"
                                                    class="form-control" id="bank_name" placeholder="Enter Bank's Name">
                                                @error('bank_name')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_account_no">Bank Acc. Number:</label>
                                                <input type="text" name="bank_account_no"
                                                    value="{{ old('bank_account_no', $student->user->bank_account_no) }}"
                                                    class="form-control" id="bank_account_no"
                                                    placeholder="Enter Bank's Account Number">
                                                @error('bank_account_no')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="bank_branch">Bank Branch:</label>
                                                <input type="text" name="bank_branch"
                                                    value="{{ old('bank_branch', $student->user->bank_branch) }}"
                                                    class="form-control" id="bank_branch"
                                                    placeholder="Enter Bank's Branch">
                                                @error('bank_branch')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="tab">
                                    <div class="col-lg-12 col-md-12">
                                        {{-- <div class="hr-line-dashed"></div>
                                        <h5>Student's Social Information:</h5>
                                        <div class="hr-line-dashed"></div> --}}
                                        {{-- <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="username">Username:</label>
                                                <input type="text" name="username"
                                                    value="{{ old('username', $student->user->username) }}"
                                                    class="form-control" id="username" placeholder="Enter Username">
                                                @error('username')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="password">Password:</label>
                                                <input type="text" name="password"
                                                    value="{{ old('password', $student->user->password) }}"
                                                    class="form-control" id="password" placeholder="Enter Password">
                                                @error('password')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="password">Password Confirmation</label>
                                                <input id="password-confirm" type="password"
                                                    value="{{ old('password_confirmation') }}"
                                                    placeholder="Confirm Password" class="form-control"
                                                    name="password_confirmation">
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="facebook">Facebook:</label>
                                                <input type="text" name="facebook"
                                                    value="{{ old('facebook', $student->user->facebook) }}"
                                                    class="form-control" id="facebook"
                                                    placeholder="Enter Facebook Profile URL">
                                                @error('facebook')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="twitter">Twitter:</label>
                                                <input type="text" name="twitter"
                                                    value="{{ old('twitter', $student->user->twitter) }}"
                                                    class="form-control" id="twitter"
                                                    placeholder="Enter Twitter Profile URL">
                                                @error('twitter')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="linkedin">LinkedIn:</label>
                                                <input type="text" name="linkedin"
                                                    value="{{ old('linkedin', $student->user->linkedin) }}"
                                                    class="form-control" id="linkedin"
                                                    placeholder="Enter LinkedIn Profile URL">
                                                @error('linkedin')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                <label for="instagram">Instagram:</label>
                                                <input type="text" name="instagram"
                                                    value="{{ old('instagram', $student->user->instagram) }}"
                                                    class="form-control" id="instagram"
                                                    placeholder="Enter Instagram Profile URL">
                                                @error('linkedin')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-12 col-md-12 d-flex flex-wrap mt-4">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="hr-line-dashed"></div>
                                                <h5>Additional Information:</h5>
                                                <div class="hr-line-dashed"></div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="note">Note :</label>
                                                    <textarea name="note" class="form-control" id="note" placeholder="Note.." rows="15" cols="50">
                                                        {{ old('note', $student->user->note) }}
                                                    </textarea>
                                                    @error('note')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-lg-3 col-sm-3 mt-2">
                                                    <label for="transfer_certificate">Transfer Certificate:</label>
                                                    @if ($student->transfer_certificate)
                                                        <p>Current Transfer Certificate:
                                                            {{ $student->transfer_certificate }}</p>
                                                    @endif
                                                    <input type="file" name="transfer_certificate"
                                                        class="form-control" id="pdf" accept=".pdf">
                                                    @error('transfer_certificate')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-lg-3 col-sm-3 mt-4">
                                                    <div class="btn-group">
                                                        <input type="radio" class="btn-check" name="is_active"
                                                            id="option1" value="1" autocomplete="off"
                                                            {{ old('is_active', $student->user->is_active) == 1 ? 'checked' : '' }}>
                                                        <label class="btn btn-secondary" for="option1">Active</label>

                                                        <input type="radio" class="btn-check" name="is_active"
                                                            id="option2" value="0" autocomplete="off"
                                                            {{ old('is_active', $student->user->is_active) == 0 ? 'checked' : '' }}>
                                                        <label class="btn btn-secondary" for="option2">Inactive</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- DISPLAY FOR THE EXTRA STEPS
                                <div class="tab">Login Info:
                                    <p><input placeholder="Username..." oninput="this.className = ''"></p>
                                    <p><input placeholder="Password..." oninput="this.className = ''"></p>
                                </div> --}}

                                <div class=" d-flex justify-content-end mt-4">
                                    <div style="">
                                        <button class="btn btn-secondary" type="button" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button class="btn btn-primary" id="submitBtn" type="submit"
                                            style="display: none;">Submit</button>

                                        <button class="btn btn-primary" type="button" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>

                                {{-- <!--This indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step">Basic Information</span>
                                    <span class="step">Parent Information</span>
                                    <span class="step">Social Information</span>
                                    <span class="step"></span>
                                </div> --}}

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
        $(document).ready(function() {

            toggleGuardianFields();

            // Your other JavaScript code here...

            // Attach change event handlers to the radio buttons
            $('input[name="guardian_is"]').change(function() {
                toggleGuardianFields();
            });

            // Attach change event handler to the class dropdown
            $('select[name="class_id"]').change(function() {
                // Get the selected class ID
                var classId = $(this).val();

                // Fetch sections based on the selected class ID
                $.ajax({
                    url: 'get-sections/' + classId, // Replace with the actual route
                    type: 'GET',
                    success: function(data) {
                        // Clear existing options
                        $('select[name="section_id"]').empty();

                        // Add the default option
                        $('select[name="section_id"]').append(
                            '<option disabled>Select Section</option>');

                        // Add new options based on the fetched sections
                        $.each(data, function(key, value) {
                            $('select[name="section_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";

            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }

            if (n == (x.length - 1)) {
                // If it's the last tab, hide the "Next" button and show the "Submit" button
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("submitBtn").style.display = "inline";
            } else {
                // If it's not the last tab, show the "Next" button and hide the "Submit" button
                document.getElementById("nextBtn").style.display = "inline";
                document.getElementById("submitBtn").style.display = "none";
            }

            fixStepIndicator(n);
        }


        // function nextPrev(n) {
        //     // This function will figure out which tab to display
        //     var x = document.getElementsByClassName("tab");
        //     // Exit the function if any field in the current tab is invalid:
        //     if (n == 1 && !validateForm()) return false;
        //     // Hide the current tab:
        //     x[currentTab].style.display = "none";
        //     // Increase or decrease the current tab by 1:
        //     currentTab = currentTab + n;
        //     // if you have reached the end of the form... :
        //     if (currentTab >= x.length) {
        //         //...the form gets submitted:
        //         document.getElementById("regForm").submit();
        //         return false;
        //     }
        //     // Otherwise, display the correct tab:
        //     showTab(currentTab);
        // }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) return false;
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                // Use AJAX to submit the form
                submitFormWithAjax();
                return false;
            }
            showTab(currentTab);
        }

        function submitFormWithAjax() {
            var form = document.getElementById("regForm");
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", form.action);
            xhr.setRequestHeader("X-CSRF-TOKEN", formData.get('_token'));
            xhr.setRequestHeader("X-HTTP-Method-Override", form.method);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Handle the response or redirect as needed
                }
            };
            xhr.send(formData);
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

    <script>
        $(document).ready(function() {

            // $(document).on('change', '.state_id', function() {
            //     var state_id = $(this).val();
            //     // Retrieve and log the data attribute value
            //     var currentiteration = $(this).data("iteration");
            //     var append_to = 'district_id';
            //     $.ajax({
            //         url: '/admin/get-district-by-state/' + state_id,
            //         type: 'GET',
            //         success: function(response) {
            //             var clearThisData = $('#' + append_to + '').empty();
            //             if (response.length > 0) {
            //                 $('#' + append_to + '').append(
            //                     '<option disabled value="">Choose District</option>');
            //                 $.each(response, function(key, value) {
            //                     $('#' + append_to + '').append('<option value="' + value
            //                         .id + '" ' + (value.id == selectedDistrictId ?
            //                             'selected' : '') +
            //                         '>' + value.name + '</option>');
            //                 });
            //             } else {
            //                 $('#' + append_to + '').append(
            //                     '<option value="">No districts found</option>');
            //             }

            //             // Clear the municipalities dropdown when the state changes
            //             $('#municipalitiy_id').empty().append(
            //                 '<option value="">Choose Municipality</option>');
            //         },
            //         error: function() {
            //             console.log("error in the ajax");
            //         }
            //     });
            // });



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

    <script>
        function toggleGuardianFields() {
            var otherFieldsContainer = document.getElementById('otherGuardianFields');
            var guardianOtherRadio = document.getElementById('guardian_other');

            if (guardianOtherRadio.checked) {
                otherFieldsContainer.style.display = 'flex'; // Show the additional fields
                otherFieldsContainer.style.flexWrap = 'wrap'; // Show the additional fields
                otherFieldsContainer.style.justifyContent = 'space-between'; // Show the additional fields
                otherFieldsContainer.style.gap = '3px'; // Show the additional fields
            } else {
                otherFieldsContainer.style.display = 'none'; // Hide the additional fields
            }
        }
    </script>
@endsection
