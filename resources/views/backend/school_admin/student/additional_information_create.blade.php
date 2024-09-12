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
                        <form id="regForm" action="{{ route('admin.students.additionalInformation.update', $student->id) }}" method="POST">
                            @csrf

                            <div class="form-group">

                                <div class="col-lg-12 col-md-12 d-flex flex-wrap mt-4">
                                    <div class="col-lg-12 col-md-12">

                                        <div class="hr-line-dashed"></div>
                                        <h5>Student's Bank Information:</h5>
                                        <div class="hr-line-dashed"></div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="bank_name">Bank's Name:</label>
                                            <input type="text" name="bank_name" value="{{ old('bank_name', $student->user->bank_name) }}" class="form-control" id="bank_name" placeholder="Enter Bank's Name">
                                            @error('bank_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="bank_account_no">Bank Acc. Number:</label>
                                            <input type="text" name="bank_account_no" value="{{ old('bank_account_no', $student->user->bank_account_no) }}" class="form-control" id="bank_account_no" placeholder="Enter Bank's Account Number">
                                            @error('bank_account_no')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="bank_branch">Bank Branch:</label>
                                            <input type="text" name="bank_branch" value="{{ old('bank_branch', $student->user->bank_branch) }}" class="form-control" id="bank_branch" placeholder="Enter Bank's Branch">
                                            @error('bank_branch')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">

                                    <div class="col-lg-12 col-md-12 d-flex gap-3 flex-wrap justify-content-between">
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="username">Username:</label>
                                            <input type="text" name="username" value="{{ old('username', $student->user->username) }}" class="form-control" id="username" placeholder="Enter Username">
                                            @error('username')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="facebook">Facebook:</label>
                                            <input type="text" name="facebook" value="{{ old('facebook',$student->user->facebook) }}" class="form-control" id="facebook" placeholder="Enter Facebook Profile URL">
                                            @error('facebook')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="twitter">Twitter:</label>
                                            <input type="text" name="twitter" value="{{ old('twitter', $student->user->twitter) }}" class="form-control" id="twitter" placeholder="Enter Twitter Profile URL">
                                            @error('twitter')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="linkedin">LinkedIn:</label>
                                            <input type="text" name="linkedin" value="{{ old('linkedin', $student->user->linkedin) }}" class="form-control" id="linkedin" placeholder="Enter LinkedIn Profile URL">
                                            @error('linkedin')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-3 col-sm-3 mt-2">
                                            <label for="instagram">Instagram:</label>
                                            <input type="text" name="instagram" value="{{ old('instagram', $student->user->instagram) }}" class="form-control" id="instagram" placeholder="Enter Instagram Profile URL">
                                            @error('linkedin')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 pt20">

                                            <button type="submit">Save</button>
                                        </div>
                                    </div>

                                </div>




                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
