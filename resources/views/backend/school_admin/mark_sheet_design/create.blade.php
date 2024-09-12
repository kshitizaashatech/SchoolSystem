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
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="myForm" novalidate="novalidate" method="POST"
                            action="{{ route('admin.mark-sheetdesigns.store') }}" enctype="multipart/form-data">
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
                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="heading">Heading</label>
                                    <input type="text" name="heading" value="{{ old('heading') }}" class="form-control"
                                        id="heading" placeholder="Enter heading" required>
                                    @error('heading')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                        id="title" placeholder="Enter title" required>
                                    @error('title')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
{{--
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="school_name">School Name</label>
                                    <input type="school_name" name="school_name" class="form-control"
                                        value="{{ old('school_name') }}" id="school_name"
                                        placeholder="Enter School Name" required>
                                    @error('school_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_center">Exam Center</label>
                                    <input type="exam_center" name="exam_center" class="form-control"
                                        value="{{ old('exam_center') }}" id="exam_center"
                                        placeholder="Enter Exam Center" required>
                                    @error('exam_center')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_name">Exam Name</label>
                                    <input type="exam_name" name="exam_name" class="form-control"
                                        value="{{ old('exam_name') }}" id="exam_name" placeholder="Enter Exam Name"
                                        required>
                                    @error('exam_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>


                                {{-- <div class="form-group col-lg-4 col-sm-4">
                                    <label for="exam_session">Exam Session</label>
                                    <input type="exam_session" name="exam_session" class="form-control"
                                        value="{{ old('exam_session') }}" id="exam_session"
                                        placeholder="Enter Exam Center" required>
                                    @error('exam_session')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="content">Content</label>
                                    <input type="content" name="            $table->string('content')->nullable();
                                        " class="form-control" value="{{ old('content') }}" id="content"
                                        placeholder="Enter Footer Content" required>
                                    @error('content')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>


                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="content_footer">Footer Content</label>
                                    <input type="content_footer" name="content_footer" class="form-control"
                                        value="{{ old('content_footer') }}" id="content_footer"
                                        placeholder="Enter Footer Content" required>
                                    @error('content_footer')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                {{-- <div class="form-group col-md-4 col-xs-12">
                                    <label>Date<span class="must">*</span></label>

                                    <div class="col-sm-10">
                                        <input type="date" value="{{ old('date') }}" name="date" class="input-text"
                                            id="dynamic_date" autofocus required>
                                    </div>
                                </div> --}}



                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Class Teacher Remarks<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_classteacher_remarks"
                                                id="is_classteacher_remarks_option1" value="1" autocomplete="off"
                                                checked />
                                            <label class="btn btn-secondary"
                                                for="is_classteacher_remarks_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_classteacher_remarks"
                                                id="is_classteacher_remarks_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary"
                                                for="is_classteacher_remarks_option2">Inactive</label>
                                        </div>
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
                                    <label>Division<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_division"
                                                id="is_division_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_division_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_division"
                                                id="is_division_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_division_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Rank<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_rank" id="is_rank_option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="is_rank_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_rank" id="is_rank_option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="is_rank_option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group col-lg-4 col-sm-4">
                                    <label>Is Custom Field<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_custom_field"
                                                id="is_custom_field_option1" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary"
                                                for="is_custom_field_option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_custom_field"
                                                id="is_custom_field_option2" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary"
                                                for="is_custom_field_option2">Inactive</label>
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
                                    <label>Is Photo<span class="must">*</span></label>
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

                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>Left Logo</h5>
                                        <div class="hr-line-dashed"></div>
                                        <img src="" id="left_logo">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="left_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Right Logo</h5>
                                        <div class="hr-line-dashed"></div>
                                        <img src="" id="right_logo">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="right_logo" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <h5>Background Image</h5>
                                        <div class="hr-line-dashed"></div>
                                        <img src="" id="image_background">
                                        <div class="form-group">
                                            <input type="file" id="imageFile" class="form-control" placeholder="Image" name="background_img" data-ratio="16" data-ratiowidth="16">
                                        </div>
                                    </div>
                                </div>

                        </div>




                            <div class="row">
                                <div class="col-lg-4">
                                    <h5>Left Sign</h5>
                                    <div class="hr-line-dashed"></div>
                                    <img src="" id="left_sign">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                            name="left_sign" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    {{-- <div id="previewWrapper" class="hidden">
                                        <br>
                                        <img id="croppedImagePreview" height="150"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                            type="button" id="removeCroppedImage"
                                            style="margin-top: 7px;">Remove</button>
                                    </div> --}}
                                </div>

                                <div class="col-lg-4">
                                    <h5>Middle Sign</h5>
                                    <div class="hr-line-dashed"></div>
                                    <img src="" id="middle_sign">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                            name="middle_sign" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    {{-- <div id="previewWrapper" class="hidden">
                                        <br>
                                        <img id="croppedImagePreview" height="150"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                            type="button" id="removeCroppedImage"
                                            style="margin-top: 7px;">Remove</button>
                                    </div> --}}
                                </div>

                                <div class="col-lg-4">
                                    <h5>Right Sign</h5>
                                    <div class="hr-line-dashed"></div>
                                    <img src="" id="right_sign">
                                    <div class="form-group">
                                        <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                            name="right_sign" data-ratio="16" data-ratiowidth="16">
                                    </div>
                                    {{-- <div id="previewWrapper" class="hidden">
                                        <br>
                                        <img id="croppedImagePreview" height="150"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                            type="button" id="removeCroppedImage"
                                            style="margin-top: 7px;">Remove</button>
                                    </div> --}}
                                </div>
                            </div>




                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                    </div>
                    </form>
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
