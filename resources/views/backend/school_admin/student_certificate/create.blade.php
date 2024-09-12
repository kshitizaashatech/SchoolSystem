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
            @include('backend.school_admin.student_certificate.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.student-certificates.store') }}" enctype="multipart/form-data">

                                @csrf
                                <div class="">
                                    <div class="form-group col-lg-8 col-sm-8">
                                        <label for="certificate_name">Certificate Name</label>
                                        <input type="text" name="certificate_name" class="form-control" id="certificate_name"
                                            value="{{ old('certificate_name') }}" placeholder="Enter Certificate Name" required>
                                        @error('certificate_name')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-8 col-sm-8 mt-2">
                                        <label for="certificate_text">Certificate Text</label>
                                        <textarea name="certificate_text" id="certificate_text" cols="30" rows="10">
                                            {{ old('certificate_text') }}
                                        </textarea>
                                        @error('certificate_text')
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
