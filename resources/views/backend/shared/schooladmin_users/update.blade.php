@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.schooladmin_users.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST"
                                action="{{ route('admin.school-adminusers.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <div class="hr-line-dashed"></div>
                                    <h5>School User's General Information:</h5>
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


                                    <!-- Profile Picture Section -->
                                    <div class="hr-line-dashed"></div>
                                    <h5>School Admin User's Profile Picture:</h5>
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
@endsection
