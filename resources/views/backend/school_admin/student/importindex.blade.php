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
                                    <a class="btn btn-primary btn-sm" href="{{ asset('sample-files/sample_doc.csv') }}"><i
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
                                (2018-06-06). <br />
                                3. Duplicate Admission Number (unique) rows will not be imported. <br />
                                4. For student Gender use Male, Female value. <br />

                                5. For student Blood Group use O+, A+, B+, AB+, O-, A-, B-, AB- value.<br />

                                6. For RTE use Yes, No value.<br />

                                7. For If Guardian Is user father,mother,other value.<br />

                                8. Category name comes from other table so for category, enter Category Id
                                (Category
                                Id
                                can
                                be
                                found
                                on category page ).<br />

                                9. Student house comes from other table so for student house, enter Student
                                House Id
                                (Student
                                House
                                Id can be found on student house page ).
                                <hr />
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="sampledata">
                                    <thead>
                                        <tr>
                                            state_id <th><span class=text-red>*</span><span>State</span></th>
                                            district_id <th><span class=text-red>*</span><span>District</span></th>
                                            municipality_id <th><span class=text-red>*</span><span>Municiplaity</span></th>
                                            ward_id <th><span class=text-red>*</span><span>Ward</span></th>
                                            firstname <th><span class=text-red>*</span><span>First Name</span></th>
                                            middlename <th><span>Middle Name</span></th>
                                            lastname <th><span class=text-red>*</span><span>Last Name</span></th>
                                            email <th><span>Email</span></th>
                                            local address <th><span>Local Address</span></th>
                                            permanent address <th><span>Permanent Address</span></th>
                                            gender <th><span class=text-red>*</span><span>Gender</span></th>
                                            religion <th><span>Religion</span></th>
                                            dob <th><span class=text-red>*</span><span>Date of Birth</span>
                                            </th>
                                            blood_group <th><span>Blood Group</span></th>
                                            father_name <th><span>Father Name</span></th>
                                            father_phone <th><span>Father Phone</span></th>
                                            father_occupation <th><span>Father Occupation</span></th>
                                            mother_name <th><span>Mother Name</span></th>
                                            mother_phone <th><span>Mother Phone</span></th>
                                            mother_occupation <th><span>Mother Occupation</span></th>
                                            emergency_contact_person <th><span>Emergency Contact Person</span></th>
                                            emergency_contact_phone <th><span>Emergency Contact Phone</span></th>
                                            admission_no <th><span class=text-red>*</span><span>Admission
                                                No</span>
                                        </th>
                                        roll_no <th><span class=text-red>*</span><span>Roll No.</span></th>
                                        admission_date <th><span class=text-red>*</span><span>Admission
                                                Date</span>
                                        </th>
                                        school_house<th><span class=text-red>*</span><span>School House
                                            </span>
                                    </th>
                                            guardian_is <th><span class=text-red>*</span><span>If Guardian
                                                    Is</span>
                                            </th>
                                            guardian_name <th><span class=text-red>*</span><span>Guardian
                                                Name</span>
                                        </th>
                                            guardian_phone <th><span class=text-red>*</span><span>Guardian
                                            Phone</span>
                                        </th>
                                             guardian_relation <th><span class=text-red>*</span><span>Guardian
                                            Relation</span>
                                        </th>
                                            guardian_email <th><span class=text-red>*</span><span>Guardian
                                            Email</span>
                                         </th>

                                           
                                           
                                            {{-- class <th><span>Class</span></th>
                                            section <th><span>Section</span></th>
                                            mobileno <th><span>Mobile No.</span></th>                         
                                            bank name <th><span>Bank Name</span></th>
                                            bank account <th><span>Bank Account</span></th>
                                            bank branch <th><span>Bank Branch</span></th>
                                            username <th><span>User Name</span></th>
                                            password <th><span>Password</span></th>
                                            facebook<th><span>Facebook</span></th>
                                            twitter<th><span>Twitter</span></th>
                                            linkedin<th><span>LinkedIN</span></th>
                                            instagram<th><span>Instagram</span></th> --}}

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            {{-- <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td>
                                            <td>Sample Data</td> --}}

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr />
                            <form action="{{ route('admin.students.bulkimport') }}" id="employeeform" name="employeeform"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    <input type='hidden' name='ci_csrf_token' value='' />
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 d-flex justify-content-between">
                                            <div class=" col-lg-3 col-sm-3 mt-2">
                                                <label for="class_id"> Class:</label>
                                                <div class="select">
                                                    <select name="class_id">
                                                        <option value="">Select Class</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->class }}</option>
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
                                                        <option disabled>Select Section</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                @error('section_id')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Add hidden input fields for class_id and section_id -->
                                        <input type="hidden" name="selected_class_id" id="selected_class_id">
                                        <input type="hidden" name="selected_section_id" id="selected_section_id">

                                        <div class="col-md-6 pt20">
                                            <input type="file" name="file">
                                            <button type="submit">Import</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            {{-- <form action="{{ route('admin.students.bulkimport') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file">
                            <button type="submit">Import</button>




                        </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Event handling for class_id dropdown
        $('select[name="class_id"]').change(function() {
            var classId = $(this).val();

            $.ajax({
                url: '{{ route('admin.student.get-sections', ['classId' => ':classId']) }}'.replace(
                    ':classId', classId),
                type: 'GET',
                success: function(data) {
                    $('select[name="section_id"]').empty().append(
                        '<option disabled selected>Select Section</option>');

                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append('<option value="' + key + '">' +
                            value + '</option>');
                    });

                    $('#selected_class_id').val(classId);
                    $('#selected_section_id').val('');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sections:', error);
                }
            });
        });

        // Event handling for section_id dropdown
        $('select[name="section_id"]').change(function() {
            var sectionId = $(this).val();
            console.log(sectionId);
            $('#selected_section_id').val(sectionId);
        });
    </script>
@endsection
