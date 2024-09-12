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
                            <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.admit-carddesigns.store') }}" enctype="multipart/form-data">

                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="template">Template</label>
                                        <input type="text" name="template" class="form-control" id="template"
                                            value="{{ old('template') }}" placeholder="Enter Template" required>
                                        @error('template')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="heading">Heading</label>
                                        <input type="text" name="heading" value="{{ old('heading') }}"
                                            class="form-control" id="heading" placeholder="Enter heading" required>
                                        @error('heading')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="form-control" id="title" placeholder="Enter title" required>
                                        @error('title')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="exam_name">Exam Name</label>
                                        <input type="exam_name" name="exam_name" class="form-control" value="{{ old('exam_name') }}" id="exam_name"
                                            placeholder="Enter Exam Name" required>
                                        @error('exam_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="school_name">School Name</label>
                                        <input type="school_name" name="school_name" class="form-control" value="{{ old('school_name') }}" id="school_name"
                                            placeholder="Enter School Name" required>
                                        @error('school_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="exam_center">Exam Center</label>
                                        <input type="exam_center" name="exam_center" class="form-control" value="{{ old('exam_center') }}" id="exam_center"
                                            placeholder="Enter Exam Center" required>
                                        @error('exam_center')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="left_logo">Left Logo</label>
                                       <img src="" id="left_logo">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                                name="left_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePreview" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage"
                                                style="margin-top: 7px;">Remove</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="right_logo">Right Logo</label>
                                         <img src="" id="right_logo">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                                name="right_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePreview" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage"
                                                style="margin-top: 7px;">Remove</button>
                                        </div>
                                    </div>



                                    <div class="col-lg-4">
                                        <label for="image_sign">Signature</label>
                                        <img src="" id="image_sign" style="width: 20%;">
                                        <div class="form-group">
                                            <input type="file" id="imageFile_sign" class="form-control"
                                                placeholder="Image" name="sign" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePrelist_sign" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic_sign"
                                                tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button" id="removeCroppedImage" style="margin-top: 7px;">Remove
                                            </button>
                                        </div>
                                    </div>

                                    <h5>Background Image</h5>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-4">
                                        <img src="" id="image_background">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                                name="background_img" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                        <div id="previewWrapper" class="hidden">
                                            <br>
                                            <img id="croppedImagePreview" height="150"><br>
                                            <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                            <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button"
                                                id="removeCroppedImage" style="margin-top: 7px;">Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label>Name<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_name" id="is_name_option1"
                                                    value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="is_name_option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_name" id="is_name_option2"
                                                    value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="is_name_option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label>Father Name<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_father_name"
                                                    id="is_father_name_option1" value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="is_father_name_option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_father_name"
                                                    id="is_father_name_option2" value="0" autocomplete="off" />
                                                <label class="btn btn-secondary"
                                                    for="is_father_name_option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label>Mother Name<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_mother_name"
                                                    id="is_mother_name_option1" value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="is_mother_name_option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_mother_name"
                                                    id="is_mother_name_option2" value="0" autocomplete="off" />
                                                <label class="btn btn-secondary"
                                                    for="is_mother_name_option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>



                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>DOB<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_dob" id="is_dob_option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_dob_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_dob" id="is_dob_option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_dob_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Admission Number<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_admission_no"
                                                id="is_admission_no_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary"
                                                for="is_admission_no_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_admission_no"
                                                id="is_admission_no_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary"
                                                for="is_admission_no_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Roll Number<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_roll_no"
                                                id="is_roll_no_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_roll_no_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_roll_no"
                                                id="is_roll_no_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_roll_no_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Address<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_address"
                                                id="is_address_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_address_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_address"
                                                id="is_address_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_address_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Gender<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_gender"
                                                id="is_gender_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_gender_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_gender"
                                                id="is_gender_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_gender_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-sm-4">
                                    <label> Photo<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_photo" id="is_photo1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_photo1">Active</label>

                                            <input type="radio" class="btn-check" name="is_photo" id="is_photo_option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_photo_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>


                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label>Class<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_class" id="is_class_option1"
                                                    value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary"
                                                    for="is_custom_field_option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_class" id="is_class_option2"
                                                    value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="is_class_option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label>Session<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="is_session"
                                                    id="is_session_option1" value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="is_session_option1">Active</label>

                                                <input type="radio" class="btn-check" name="is_session"
                                                    id="is_session_option2" value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="is_session_option2">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-4">
                                        <label for="content_footer">Footer Content</label>
                                        <input type="content_footer" name="content_footer" class="form-control" value="{{ old('content_footer') }}" id="content_footer"
                                            placeholder="Enter Footer Content" required>
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
