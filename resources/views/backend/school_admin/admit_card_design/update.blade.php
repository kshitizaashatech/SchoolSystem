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
        @include('backend.school_admin.admit_card_design.partials.action')
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="quickForm" novalidate="novalidate" method="POST"
                            action="{{ route('admin.admit-carddesigns.update', $admin_card_design->id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="template">Template</label>
                                    <input type="text" name="template" class="form-control" id="template"
                                        value="{{ old('template', $admin_card_design->template) }}"
                                        placeholder="Enter Template" required>
                                    @error('template')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="heading">Heading</label>
                                    <input type="text" name="heading"
                                        value="{{ old('heading', $admin_card_design->heading) }}" class="form-control"
                                        id="heading" placeholder="Enter heading" required>
                                    @error('heading')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="title">Title</label>
                                    <input type="text" name="title"
                                        value="{{ old('title', $admin_card_design->title) }}" class="form-control"
                                        id="title" placeholder="Enter title" required>
                                    @error('title')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_name">Exam Name</label>
                                    <input type="exam_name" name="exam_name" class="form-control"
                                        value="{{ old('exam_name',$admin_card_design->exam_name) }}" id="exam_name"
                                        placeholder="Enter Exam Name" required>
                                    @error('exam_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="school_name">School Name</label>
                                    <input type="school_name" name="school_name" class="form-control"
                                        value="{{ old('school_name',$admin_card_design->school_name ) }}"
                                        id="school_name" placeholder="Enter School Name" required>
                                    @error('school_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_center">Exam Center</label>
                                    <input type="exam_center" name="exam_center" class="form-control"
                                        value="{{ old('exam_center',$admin_card_design->exam_center  ) }}"
                                        id="exam_center" placeholder="Enter Exam Center" required>
                                    @error('exam_center')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>


                                <div class="col-lg-4">
                                    <label for="left_logo">Left Logo</label>

                                    @php
                                        $oldLeftLogo = old('left_logo', $admin_card_design->left_logo ?? '');
                                    @endphp
                                    <img src="{{ $oldLeftLogo ? asset($oldLeftLogo) : '' }}" id="image" style="width: 20%;">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="left_logo" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    <div id="previewWrapper" class="{{ $oldLeftLogo ? '' : 'hidden' }}">
                                        <br>
                                        <img id="croppedImagePreview" height="150" src="{{ $oldLeftLogo ? asset($oldLeftLogo) : '' }}"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                    </div>
                                    {{-- Add a hidden field to retain the existing logo path --}}
                                    <input type="hidden" name="old_left_logo" value="{{ $oldLeftLogo }}">
                                </div>


                                <div class="col-lg-4">
                                    <label for="right_logo">Right Logo</label>
                                    @php
                                        $oldRightLogo = old('right_logo', $admin_card_design->right_logo ?? '');
                                    @endphp
                                    <img src="{{ $oldRightLogo ? asset($oldRightLogo) : '' }}" id="image" style="width: 20%;">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="right_logo" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    <div id="previewWrapper" class="{{ $oldRightLogo ? '' : 'hidden' }}">
                                        <br>
                                        <img id="croppedImagePreview" height="150" src="{{ $oldRightLogo ? asset($oldRightLogo) : '' }}"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                    </div>
                                    {{-- Add a hidden field to retain the existing logo path --}}
                                    <input type="hidden" name="old_right_logo" value="{{ $oldRightLogo }}">
                                </div>



                                <div class="col-lg-4">
                                    <label for="image_sign">Signature</label>
                                    @php
                                        $oldSignature = old('sign', $admin_card_design->sign ?? '');
                                    @endphp
                                    <img src="{{ $oldSignature ? asset($oldSignature) : '' }}" id="image" style="width: 20%;">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="sign" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    <div id="previewWrapper" class="{{ $oldSignature ? '' : 'hidden' }}">
                                        <br>
                                        <img id="croppedImagePreview" height="150" src="{{ $oldSignature ? asset($oldSignature) : '' }}"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                    </div>
                                    {{-- Add a hidden field to retain the existing logo path --}}
                                    <input type="hidden" name="old_sign" value="{{ $oldSignature }}">
                                </div>


                                <h5>Background Image</h5>
                                <div class="hr-line-dashed"></div>
                                <div class="col-lg-4">
                                    @php
                                        $oldBackgroundPhoto = old('background_img', $admin_card_design->background_img ?? '');
                                    @endphp
                                    <img src="{{ $oldBackgroundPhoto ? asset($oldBackgroundPhoto) : '' }}" id="image" style="width: 20%;">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="background_img" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    <div id="previewWrapper" class="{{ $oldBackgroundPhoto ? '' : 'hidden' }}">
                                        <br>
                                        <img id="croppedImagePreview" height="150" src="{{ $oldBackgroundPhoto ? asset($oldBackgroundPhoto) : '' }}"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                    </div>
                                    {{-- Add a hidden field to retain the existing logo path --}}
                                    <input type="hidden" name="old_background_img" value="{{ $oldBackgroundPhoto }}">
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_name">Name</label>
                                    <input type="is_name" name="is_name" class="form-control"
                                        value="{{ old('is_name',$admin_card_design->is_name ) }}" id="is_name"
                                        placeholder="Enter Name" required>
                                    @error('is_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_name">Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_name"
                                            id="option1_is_name" value="1" autocomplete="off"
                                            {{ old('is_name', $admin_card_design->is_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_name"
                                            id="option2_is_name" value="0" autocomplete="off"
                                            {{ old('is_name', $admin_card_design->is_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_father_name">Father Name</label>
                                    <input type="is_father_name" name="is_father_name" class="form-control"
                                        value="{{ old('is_father_name',$admin_card_design->is_father_name ) }}"
                                        id="is_father_name" placeholder="Enter Father's Name" required>
                                    @error('is_father_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_father_name">Father Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_father_name"
                                            id="option1_is_father_name" value="1" autocomplete="off"
                                            {{ old('is_father_name', $admin_card_design->is_father_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_father_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_father_name"
                                            id="option2_is_father_name" value="0" autocomplete="off"
                                            {{ old('is_father_name', $admin_card_design->is_father_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_father_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_mother_name">Mother Name</label>
                                    <input type="is_mother_name" name="is_mother_name" class="form-control"
                                        value="{{ old('is_mother_name', $admin_card_design->is_mother_name ) }}"
                                        id="is_mother_name" placeholder="Enter Mother's Name" required>
                                    @error('is_mother_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_mother_name">Mother Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_mother_name"
                                            id="option1_is_mother_name" value="1" autocomplete="off"
                                            {{ old('is_mother_name', $admin_card_design->is_mother_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_mother_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_mother_name"
                                            id="option2_is_mother_name" value="0" autocomplete="off"
                                            {{ old('is_mother_name', $admin_card_design->is_mother_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_mother_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_dob">DOB</label>
                                    <input type="is_dob" name="is_dob" class="form-control"
                                        value="{{ old('is_dob', $admin_card_design->is_dob ) }}" id="is_dob"
                                        placeholder="Enter DOB" required>
                                    @error('is_dob')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_dob">DOB</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_dob"
                                            id="option1_is_dob" value="1" autocomplete="off"
                                            {{ old('is_dob', $admin_card_design->is_dob) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_dob">Active</label>

                                        <input type="radio" class="btn-check" name="is_dob"
                                            id="option2_is_dob" value="0" autocomplete="off"
                                            {{ old('is_dob', $admin_card_design->is_dob) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_dob">Inactive</label>
                                    </div>
                                    </div>
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_admission_no">Admission Number</label>
                                    <input type="is_admission_no" name="is_admission_no" class="form-control"
                                        value="{{ old('is_admission_no', $admin_card_design->is_admission_no ) }}"
                                        id="is_admission_no" placeholder="Enter Admission Number" required>
                                    @error('is_admission_no')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_admission_no">Admission Number</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_admission_no"
                                            id="option1_is_admission_no" value="1" autocomplete="off"
                                            {{ old('is_admission_no', $admin_card_design->is_admission_no) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_admission_no">Active</label>

                                        <input type="radio" class="btn-check" name="is_admission_no"
                                            id="option2_is_admission_no" value="0" autocomplete="off"
                                            {{ old('is_admission_no', $admin_card_design->is_admission_no) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_admission_no">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_roll_no">Roll Number</label>
                                    <input type="is_roll_no" name="is_roll_no" class="form-control"
                                        value="{{ old('is_roll_no',$admin_card_design->is_roll_no  ) }}" id="is_roll_no"
                                        placeholder="Enter Roll Number" required>
                                    @error('is_roll_no')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_roll_no">Roll Number</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_roll_no"
                                            id="option1_is_roll_no" value="1" autocomplete="off"
                                            {{ old('is_roll_no', $admin_card_design->is_roll_no) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_roll_no">Active</label>

                                        <input type="radio" class="btn-check" name="is_roll_no"
                                            id="option2_is_roll_no" value="0" autocomplete="off"
                                            {{ old('is_roll_no', $admin_card_design->is_roll_no) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_roll_no">Inactive</label>
                                    </div>
                                    </div>
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_address">Addressr</label>
                                    <input type="is_address" name="is_address" class="form-control"
                                        value="{{ old('is_address',$admin_card_design->is_address) }}" id="is_address"
                                        placeholder="Enter Address" required>
                                    @error('is_address')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_address">Address</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_address"
                                            id="option1_is_address" value="1" autocomplete="off"
                                            {{ old('is_address', $admin_card_design->is_address) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_address">Active</label>

                                        <input type="radio" class="btn-check" name="is_address"
                                            id="option2_is_address" value="0" autocomplete="off"
                                            {{ old('is_address', $admin_card_design->is_address) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_address">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_gender">Gender</label>
                                    <input type="is_gender" name="is_gender" class="form-control"
                                        value="{{ old('is_gender', $admin_card_design->is_gender) }}" id="is_gender"
                                        placeholder="Enter Gender" required>
                                    @error('is_gender')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_gender">Gender</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_gender"
                                            id="option1_is_gender" value="1" autocomplete="off"
                                            {{ old('is_gender', $admin_card_design->is_gender) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_gender">Active</label>

                                        <input type="radio" class="btn-check" name="is_gender"
                                            id="option2_is_gender" value="0" autocomplete="off"
                                            {{ old('is_gender', $admin_card_design->is_gender) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_gender">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <h5>Photo</h5>
                                <div class="hr-line-dashed"></div> --}}
                                {{-- <div class="col-lg-4">
                                    @php
                                        $oldPhoto = old('is_photo', $admin_card_design->is_photo ?? '');
                                    @endphp
                                    <img src="{{ $oldPhoto ? asset($oldPhoto) : '' }}" id="image" style="width: 20%;">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image" name="is_photo" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    <div id="previewWrapper" class="{{ $oldPhoto ? '' : 'hidden' }}">
                                        <br>
                                        <img id="croppedImagePreview" height="150" src="{{ $oldPhoto ? asset($oldPhoto) : '' }}"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove</button>
                                    </div>

                                    <input type="hidden" name="old_is_photo" value="{{ $oldPhoto }}">
                                </div> --}}
                                {{-- old content --}}
                                <div class="form-group col-lg-3 col-sm-3 mt-4">
                                    <label for="is_photo">Photo</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_photo"
                                            id="option1" value="1" autocomplete="off"
                                            {{ old('is_photo', $admin_card_design->is_photo) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_photo"
                                            id="option2" value="0" autocomplete="off"
                                            {{ old('is_photo', $admin_card_design->is_photo) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2">Inactive</label>
                                    </div>
                                    </div>
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_class">Class</label>
                                    <input type="is_class" name="is_class" class="form-control"
                                        value="{{ old('is_class', $admin_card_design->is_class) }}" id="is_class"
                                        placeholder="Enter Class" required>
                                    @error('is_class')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-3 col-sm-3 mt-4">
                                    <label for="is_class">Class</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_class"
                                            id="option1_is_class" value="1" autocomplete="off"
                                            {{ old('is_class', $admin_card_design->is_class) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_class">Active</label>

                                        <input type="radio" class="btn-check" name="is_class"
                                            id="option2_is_class" value="0" autocomplete="off"
                                            {{ old('is_class', $admin_card_design->is_class) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_class">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_session">Session</label>
                                    <input type="is_session" name="is_session" class="form-control"
                                        value="{{ old('is_session',$admin_card_design->is_session ) }}" id="is_session"
                                        placeholder="Enter Session" required>
                                    @error('is_session')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-3 col-sm-3 mt-4">
                                    <label for="is_session">Session</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_session"
                                            id="option1_is_session" value="1" autocomplete="off"
                                            {{ old('is_session', $admin_card_design->is_session) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_session">Active</label>

                                        <input type="radio" class="btn-check" name="is_session"
                                            id="option2_is_session" value="0" autocomplete="off"
                                            {{ old('is_session', $admin_card_design->is_session) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_session">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="content_footer">Footer Content</label>
                                    <input type="content_footer" name="content_footer" class="form-control"
                                        value="{{ old('content_footer',$admin_card_design->content_footer ) }}"
                                        id="content_footer" placeholder="Enter Footer Content" required>
                                    @error('content_footer')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
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
@include('backend.includes.cropperjs')


@endsection
