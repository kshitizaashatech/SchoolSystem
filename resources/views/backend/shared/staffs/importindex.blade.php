@extends('backend.layouts.master')
@section('content')
    <!-- Main content -->
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="box box-info" style="padding:5px;">
                            <div class="box-header with-border">

                                <div class="pull-right box-tools">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ asset('sample-files/sample_staffImport.csv') }}"><i
                                            class="fa fa-download"></i>
                                        Download
                                        Sample
                                        Import
                                        File
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <br />
                                1. Your CSV data should be in the format below. The first line of your CSV
                                file
                                should
                                be
                                the
                                column
                                headers as in the table example. Also make sure that your file is UTF-8 to
                                avoid
                                unnecessary
                                encoding problems. <br />

                                2. If the column you are trying to import is date make sure that is
                                formatted in
                                format
                                Y-m-d
                                (2081-06-06). <br />
                                3. For staff Gender use Male, Female value. <br />
                                4. For staff Blood Group use O+, A+, B+, AB+, O-, A-, B-, AB- value. <br />

                                5. For staff Department use Academic, Library, Sports, Science, Commerce, Arts, Exam, Admin,
                                Finance<br />

                                6. For staff Role use Principle, Teacher, Accountant, Librarian, Receptionist<br />
                                <hr />
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <form action="{{ route('admin.staffs_import.bulkimport') }}" id="employeeform"
                                                name="employeeform" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-5">

                                                    <div class="col-sm-12, col-l-12, col-md-12">
                                                        <label>Select csv:</label><small class="req"> *</small>
                                                        <div class="form-group">

                                                            <input type="file" name="file">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group col-md-12">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="saveButton">Import</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
