@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.staff_leave.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="leave-type-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                {{-- <th>Leave Type ID</th> --}}
                                                <th>From Date</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Student</th>
                                                <th>To Date</th>
                                                {{-- <th>Apply Date</th> --}}
                                                {{-- <th>Leave Days</th> --}}
                                                <th>Status</th>
                                                <th>Docs</th>
                                                <th>Reason</th>
                                                <th>Approved By</th>
                                                <th>Approved Date</th>
                                                {{-- <th>Remarks</th> --}}
                                                {{-- <th>Request Type</th> --}}
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createLeaveType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Student Leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="leaveTypeForm" action="{{ route('admin.student-leaverequests.store') }} "
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12 col-lg-12 col-sm-12 d-flex flex-wrap gap-5">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label for="dynamic_class_id">Class</label>
                                        <div class="select">

                                            <select name="class_id" id="dynamic_class_id">
                                                <option value="">Select Class</option>
                                                @foreach ($classmanagement as $class)
                                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label for="dynamic_section_id">Section</label>
                                        <div class="select">
                                            <select name="section_id" id="dynamic_section_id">
                                                <option disabled>Select Section</option>
                                                <option value=""></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label for="dynamic_student_id">Student</label>
                                        <div class="select">
                                            <select name="student_id" id="dynamic_student_id">
                                                <option disabled>Select Student</option>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-4 mt-2">
                                        <label>From Date<span class="must">*</span></label>
                                        <div class="single-input-modal" id="datetimepicker" data-target-input="nearest">
                                            <input id="model-nepali-datepicker" name="from_date" type="text"
                                                value="{{ old('from_date') }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-4 mt-2">
                                        <label>To Date<span class="must">*</span></label>
                                        <div class="single-input-modal" id="datetimepicker" data-target-input="nearest">
                                            <input id="model-nepali-datepicker2" name="to_date" type="text"
                                                value="{{ old('to_date') }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-4 mt-2">
                                        <label>Status<span class="must">*</span></label>
                                        <div class="row">
                                            <div class="btn-group">
                                                <input type="radio" class="btn-check" name="status" id="option1"
                                                    value="1" autocomplete="off" checked />
                                                <label class="btn btn-secondary" for="option1">Approve</label>

                                                <input type="radio" class="btn-check" name="status" id="option2"
                                                    value="0" autocomplete="off" />
                                                <label class="btn btn-secondary" for="option2">Reject</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-4 mt-2">
                                        <label for="dynamic_docs">Docs</label>
                                        <div class="col-sm-10">
                                            <input type="file" value="{{ old('docs') }}" name="docs"
                                                class="input-text" id="docs">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label>Reason<span class="must">*</span></label>

                                        <div class="single-input-modal">
                                            <textarea id="reason" name="reason" class="form-control" rows="4" cols="50">
                                        
                                    </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex flex-wrap gap-5">
                                        <div class="border-top col-md-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    @include('backend.includes.nepalidate')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#leave-type-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.student-leaverequests.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'from_date',
                    name: 'from_date'
                },
                {
                    data: 'class_id',
                    name: 'class_id'
                },
                {
                    data: 'section_id',
                    name: 'section_id'
                },
                {
                    data: 'student_id',
                    name: 'student_id'
                },
                // {
                //     data: 'leave_type_id',
                //     name: 'leave_type_id'
                // },

                {
                    data: 'to_date',
                    name: 'to_date'
                },

                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'docs',
                    name: 'docs'
                },
                {
                    data: 'reason',
                    name: 'reason'
                },
                {
                    data: 'approved_by',
                    name: 'approved_by'
                },
                {
                    data: 'approved_date',
                    name: 'approved_date'
                },
                // {
                //     data: 'remarks',
                //     name: 'remarks'
                // },

                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val()).draw();
                        });
                });
            }
        });

        // Attach change event handler to the class dropdown
        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();

            // Fetch sections based on the selected class ID
            $.ajax({
                url: 'get-section-by-class/' +
                    classId, // Replace with the actual route
                type: 'GET',
                success: function(data) {
                    // Clear existing options
                    $('select[name="section_id"]').empty();

                    // Add the default option
                    $('select[name="section_id"]').append(
                        '<option>Select Section</option>');

                    // Add new options based on the fetched sections
                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append('<option value="' +
                            key + '">' + value + '</option>');
                    });
                }
            });
        });

        $('select[name="section_id"]').change(function() {
            var classId = $('select[name="class_id"]').val();
            var sectionId = $(this).val();

            $.ajax({
                url: 'get-students-by-class-section/' + classId + '/' + sectionId,
                type: 'GET',
                success: function(data) {
                    $('select[name="student_id"]').empty();
                    $('select[name="student_id"]').append(
                        '<option>Select Student</option>');
                    if (data.original.length > 0) {
                        $.each(data.original, function(index, student) {
                            $('select[name="student_id"]').append('<option value="' + student
                                .id + '">' + student.user.f_name + ' ' + student.user
                                .l_name + '</option>');
                        });
                    } else {
                        $('select[name="student_id"]').append(
                            '<option value="">No students found</option>');
                    }
                }
            });
        });

        // edit function
        $(document).on('click', '.studentLeave', function() {
            document.getElementById("exampleModalLabel").innerHTML = "Update Staff Leave";
            var id = $(this).data('id');
            // var leave_type_id = $(this).data('leave_type_id');
            var from_date = $(this).data('from_date');
            var to_date = $(this).data('to_date');
            var classId = $(this).data('class_id');
            var sectionId = $(this).data('section_id');
            var studentId = $(this).data('student_id');
            //var apply_date = $(this).data('apply_date');
            // var leave_days = $(this).data('leave_days');
            var status = $(this).data('status');
            var docs = $(this).data('docs');
            var reason = $(this).data('reason');
            var approved_by = $(this).data('approved_by');
            var approved_date = $(this).data('approved_date');
            var remarks = $(this).data('remarks');
            // var request_type = $(this).data('request_type');

            // Set values in the modal form
            $('#dynamic_class_id').val(classId).trigger('change');
            $('#dynamic_section_id').val(sectionId).trigger('change');
            $('#dynamic_student_id').val(studentId).trigger('change');
            $('#dynamic_id').val(id);
            $('#nepali-datepicker').val(from_date);
            $('#nepali-datepicker2').val(to_date);
            // $('#dynamic_docs').val(docs);
            if (status == 1) {
                $('#option1').val(status);
            } else {
                $('#option2').val(status);
            }
            $('#dynamic_docs').val('');
            if (docs) {
                $('#current-doc-info').text("Current file: " + docs);
            } else {
                $('#current-doc-info').text("No file uploaded");
            }
            $('#reason').val(reason);
            $('#remarks').val(remarks);
            // $('#dynamic_request_type').val(request_type);
            // Check the corresponding radio button
            $('input[name="status"]').prop('checked', false);
            $('input[name="status"][value="' + status + '"]').prop('checked', true);
            // If the form has an ID input field
            $('#leaveTypeForm').attr('action', '{{ route('admin.staff-leaverequests.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');


            $('#dynamic_docs').val('');
            // For sections and students, you need to fetch them again as they are dependent on the class
            fetchSections(classId, sectionId);
            fetchStudents(classId, sectionId, studentId);

            function fetchSections(classId, sectionId) {
                $.ajax({
                    url: 'get-section-by-class/' + classId,
                    type: 'GET',
                    success: function(data) {
                        var sectionSelect = $('select[name="section_id"]');
                        sectionSelect.empty();
                        sectionSelect.append('<option disabled>Select Section</option>');
                        $.each(data, function(key, value) {
                            sectionSelect.append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                        sectionSelect.val(sectionId).trigger('change');
                    }
                });
            }

            function fetchStudents(classId, sectionId, studentId) {
                $.ajax({
                    url: 'get-student-by-section/' + classId + '/' + sectionId,
                    type: 'GET',
                    success: function(data) {
                        var studentSelect = $('select[name="student_id"]');
                        studentSelect.empty();
                        if (data.length > 0) {
                            $.each(data, function(index, student) {
                                studentSelect.append('<option value="' + student.id + '">' +
                                    student.user.f_name + ' ' + student.user.l_name +
                                    '</option>');
                            });
                        } else {
                            studentSelect.append('<option value="">No students found</option>');
                        }
                        studentSelect.val(studentId);
                    }
                });
            }



            // If the form has an ID input field
            $('#leaveTypeForm').attr('action', '{{ route('admin.student-leaverequests.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createLeaveType').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
