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
            @include('backend.school_admin.mark_sheet_design.partials.action')
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="quickForm" novalidate="novalidate" method="POST"
                            action="{{ route('admin.mark-sheetdesigns.update', $mark_sheet_design->id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="template">Template</label>
                                    <input type="text" name="template" class="form-control" id="template"
                                        value="{{ old('template', $mark_sheet_design->template) }}"
                                        placeholder="Enter Template" required>
                                    @error('template')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_center">Exam Center</label>
                                    <input type="exam_center" name="exam_center" class="form-control"
                                        value="{{ old('exam_center', $mark_sheet_design->exam_center) }}"
                                        id="exam_center" placeholder="Enter Exam Center" required>
                                    @error('exam_center')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="heading">Heading</label>
                                    <input type="text" name="heading"
                                        value="{{ old('heading', $mark_sheet_design->heading) }}" class="form-control"
                                        id="heading" placeholder="Enter heading" required>
                                    @error('heading')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="title">Title</label>
                                    <input type="text" name="title"
                                        value="{{ old('title', $mark_sheet_design->title) }}" class="form-control"
                                        id="title" placeholder="Enter title" required>
                                    @error('title')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_name">Exam Name</label>
                                    <input type="exam_name" name="exam_name" class="form-control"
                                        value="{{ old('exam_name', $mark_sheet_design->exam_name) }}" id="exam_name"
                                        placeholder="Enter Exam Name" required>
                                    @error('exam_name')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="content">Content</label>
                                    <input type="content" name="content" class="form-control"
                                        value="{{ old('content', $mark_sheet_design->content) }}" id="content"
                                        placeholder="Enter Content" required>
                                    @error('content')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="content_footer">Footer Content</label>
                                    <input type="content_footer" name="content_footer" class="form-control"
                                        value="{{ old('content_footer', $mark_sheet_design->content_footer) }}"
                                        id="content_footer" placeholder="Enter Footer Content" required>
                                    @error('content_footer')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_classteacher_remarks">Class Teacher Remarks</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_classteacher_remarks"
                                            id="option1_is_classteacher_remarks" value="1" autocomplete="off"
                                            {{ old('is_classteacher_remarks', $mark_sheet_design->is_classteacher_remarks) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_classteacher_remarks">Active</label>

                                        <input type="radio" class="btn-check" name="is_classteacher_remarks"
                                            id="option2_is_classteacher_remarks" value="0" autocomplete="off"
                                            {{ old('is_classteacher_remarks', $mark_sheet_design->is_classteacher_remarks) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_classteacher_remarks">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_name">Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_name"
                                            id="option1_is_name" value="1" autocomplete="off"
                                            {{ old('is_name', $mark_sheet_design->is_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_name"
                                            id="option2_is_name" value="0" autocomplete="off"
                                            {{ old('is_name', $mark_sheet_design->is_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_father_name">Father Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_father_name"
                                            id="option1_is_father_name" value="1" autocomplete="off"
                                            {{ old('is_father_name', $mark_sheet_design->is_father_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_father_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_father_name"
                                            id="option2_is_father_name" value="0" autocomplete="off"
                                            {{ old('is_father_name', $mark_sheet_design->is_father_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_father_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_mother_name">Mother Name</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_mother_name"
                                            id="option1_is_mother_name" value="1" autocomplete="off"
                                            {{ old('is_mother_name', $mark_sheet_design->is_mother_name) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_mother_name">Active</label>

                                        <input type="radio" class="btn-check" name="is_mother_name"
                                            id="option2_is_mother_name" value="0" autocomplete="off"
                                            {{ old('is_mother_name', $mark_sheet_design->is_mother_name) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_mother_name">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_dob">DOB</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_dob"
                                            id="option1_is_dob" value="1" autocomplete="off"
                                            {{ old('is_dob', $mark_sheet_design->is_dob) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_dob">Active</label>

                                        <input type="radio" class="btn-check" name="is_dob"
                                            id="option2_is_dob" value="0" autocomplete="off"
                                            {{ old('is_dob', $mark_sheet_design->is_dob) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_dob">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_admission_no">Admission Number</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_admission_no"
                                            id="option1_is_admission_no" value="1" autocomplete="off"
                                            {{ old('is_admission_no', $mark_sheet_design->is_admission_no) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_admission_no">Active</label>

                                        <input type="radio" class="btn-check" name="is_admission_no"
                                            id="option2_is_admission_no" value="0" autocomplete="off"
                                            {{ old('is_admission_no', $mark_sheet_design->is_admission_no) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_admission_no">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_roll_no">Roll Number</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_roll_no"
                                            id="option1_is_roll_no" value="1" autocomplete="off"
                                            {{ old('is_roll_no', $mark_sheet_design->is_roll_no) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_roll_no">Active</label>

                                        <input type="radio" class="btn-check" name="is_roll_no"
                                            id="option2_is_roll_no" value="0" autocomplete="off"
                                            {{ old('is_roll_no', $mark_sheet_design->is_roll_no) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_roll_no">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_address">Address</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_address"
                                            id="option1_is_address" value="1" autocomplete="off"
                                            {{ old('is_address', $mark_sheet_design->is_address) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_address">Active</label>

                                        <input type="radio" class="btn-check" name="is_address"
                                            id="option2_is_address" value="0" autocomplete="off"
                                            {{ old('is_address', $mark_sheet_design->is_address) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_address">Inactive</label>
                                    </div>
                                    </div>
                                </div>


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_gender">Gender</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_gender"
                                            id="option1_is_gender" value="1" autocomplete="off"
                                            {{ old('is_gender', $mark_sheet_design->is_gender) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_gender">Active</label>

                                        <input type="radio" class="btn-check" name="is_gender"
                                            id="option2_is_gender" value="0" autocomplete="off"
                                            {{ old('is_gender', $mark_sheet_design->is_gender) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_gender">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_division">Division</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_division"
                                            id="option1_is_division" value="1" autocomplete="off"
                                            {{ old('is_division', $mark_sheet_design->is_division) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_division">Active</label>

                                        <input type="radio" class="btn-check" name="is_division"
                                            id="option2_is_division" value="0" autocomplete="off"
                                            {{ old('is_division', $mark_sheet_design->is_division) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_division">Inactive</label>
                                    </div>
                                    </div>
                                </div>





                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_rank">Rank</label>
                                    <input type="is_rank" name="is_rank" class="form-control"
                                        value="{{ old('is_rank', $mark_sheet_design->is_rank) }}" id="is_rank"
                                        placeholder="Enter Gender" required>
                                    @error('is_rank')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_rank">Rank</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_rank"
                                            id="option1_is_rank" value="1" autocomplete="off"
                                            {{ old('is_rank', $mark_sheet_design->is_rank) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_rank">Active</label>

                                        <input type="radio" class="btn-check" name="is_rank"
                                            id="option2_is_rank" value="0" autocomplete="off"
                                            {{ old('is_rank', $mark_sheet_design->is_rank) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_rank">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_custom_field">Is Custom Field</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_custom_field"
                                            id="option1_is_custom_field" value="1" autocomplete="off"
                                            {{ old('is_custom_field', $mark_sheet_design->is_custom_field) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_custom_field">Active</label>

                                        <input type="radio" class="btn-check" name="is_custom_field"
                                            id="option2_is_custom_field" value="0" autocomplete="off"
                                            {{ old('is_custom_field', $mark_sheet_design->is_custom_field) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_custom_field">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-3 col-sm-3">
                                    <label for="is_class">Class</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_class"
                                            id="option1_is_class" value="1" autocomplete="off"
                                            {{ old('is_class', $mark_sheet_design->is_class) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_class">Active</label>

                                        <input type="radio" class="btn-check" name="is_class"
                                            id="option2_is_class" value="0" autocomplete="off"
                                            {{ old('is_class', $mark_sheet_design->is_class) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_class">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_session">Session</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_session"
                                            id="option1_is_session" value="1" autocomplete="off"
                                            {{ old('is_session', $mark_sheet_design->is_session) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1_is_session">Active</label>

                                        <input type="radio" class="btn-check" name="is_session"
                                            id="option2_is_session" value="0" autocomplete="off"
                                            {{ old('is_session', $mark_sheet_design->is_session) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2_is_session">Inactive</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_photo">Photo</label>
                                    <div class="single-input-modal">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_photo"
                                            id="option1" value="1" autocomplete="off"
                                            {{ old('is_photo', $mark_sheet_design->is_photo) == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_photo"
                                            id="option2" value="0" autocomplete="off"
                                            {{ old('is_photo', $mark_sheet_design->is_photo) == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-secondary" for="option2">Inactive</label>
                                    </div>
                                    </div>
                                </div>






                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>Left Logo</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldLeftLogo = old('left_logo', $mark_sheet_design->left_logo ?? '');
                                        @endphp
                                        <img src="{{ $oldLeftLogo ? asset($oldLeftLogo) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="left_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_left_logo" value="{{ $oldLeftLogo }}">
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Right Logo</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldRightLogo = old('right_logo', $mark_sheet_design->right_logo ?? '');
                                        @endphp
                                        <img src="{{ $oldRightLogo ? asset($oldRightLogo) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="right_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_right_logo" value="{{ $oldRightLogo }}">
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Background Image</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldBackgroundPhoto = old('image_background', $mark_sheet_design->image_background ?? '');
                                        @endphp
                                        <img src="{{ $oldBackgroundPhoto ? asset($oldBackgroundPhoto) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="image_background" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_image_background" value="{{ $oldBackgroundPhoto }}">
                                    </div>
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="school_name">School Name</label>
                                    <input type="school_name" name="school_name" class="form-control"
                                        value="{{ old('school_name', $mark_sheet_design->school_name) }}"
                                        id="school_name" placeholder="Enter School Name" required>
                                    @error('school_name')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_session">Exam Session</label>
                                    <input type="exam_session" name="exam_session" class="form-control"
                                        value="{{ old('exam_session', $mark_sheet_design->exam_session) }}"
                                        id="exam_session" placeholder="Enter Exam Center" required>
                                    @error('exam_session')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}

                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>Left Sign</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldLeftSign = old('left_sign', $mark_sheet_design->left_sign ?? '');
                                        @endphp
                                        <img src="{{ $oldLeftSign ? asset($oldLeftSign) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="left_sign" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_left_sign" value="{{ $oldLeftSign }}">
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Middle Sign</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldMiddleSign = old('middle_sign', $mark_sheet_design->middle_sign ?? '');
                                        @endphp
                                        <img src="{{ $oldMiddleSign ? asset($oldMiddleSign) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="middle_sign" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_middle_sign" value="{{ $oldMiddleSign }}">
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Right Sign</h5>
                                        <div class="hr-line-dashed"></div>
                                        @php
                                            $oldRightSign = old('right_sign', $mark_sheet_design->right_sign ?? '');
                                        @endphp
                                        <img src="{{ $oldRightSign ? asset($oldRightSign) : '' }}" id="image" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="right_sign" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <input type="hidden" name="old_right_sign" value="{{ $oldRightSign }}">
                                    </div>
                                </div>





                                {{-- <div class="form-group col-md-4 col-xs-12">
                                    <label>Date<span class="must">*</span></label>

                                    <div class="col-sm-10">
                                        <input type="date" value="{{ old('date', $mark_sheet_design->date) }}"
                                            name="date" class="input-text" id="dynamic_date" autofocus required>
                                    </div>
                                </div> --}}

                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_classteacher_remarks">Class Teacher Remarks</label>
                                    <input type="is_classteacher_remarks" name="is_classteacher_remarks"
                                        class="form-control"
                                        value="{{ old('is_classteacher_remarks', $mark_sheet_design->is_classteacher_remarks) }}"
                                        id="is_classteacher_remarks" placeholder="Enter Class Teacher Remarks" required>
                                    @error('is_classteacher_remarks')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}




















                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_division">Division</label>
                                    <input type="is_division" name="is_division" class="form-control"
                                        value="{{ old('is_division', $mark_sheet_design->is_division) }}"
                                        id="is_division" placeholder="Enter Gender" required>
                                    @error('is_division')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}




                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="is_custom_field">Is Custom Field</label>
                                    <input type="is_custom_field" name="is_custom_field" class="form-control"
                                        value="{{ old('is_custom_field', $mark_sheet_design->is_custom_field) }}"
                                        id="is_custom_field" placeholder="Enter Gender" required>
                                    @error('is_custom_field')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}















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
