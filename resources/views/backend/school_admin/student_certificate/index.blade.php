@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.student_certificate.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="student-certificate-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Biometric Attendance</th>
                                                {{-- <th>Attendance Type ID</th> --}}
                                                <th>Date</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
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

        <div class="modal fade" id="createStudentCertificate" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Student Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="studentCertificateForm"
                            action="{{ route('admin.student-certificates.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">

                                <div class="p-2 label-input">
                                    <label>Certificate Name<span class="must"> *</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('certificate_name') }}"
                                            name="certificate_name" class="input-text single-input-text" id="dynamic_certificate_name"
                                            autofocus required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Header Left Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('header_left_text') }}"
                                            name="header_left_text" class="input-text single-input-text" id="dynamic_header_left_text"
                                            autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Header Center Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('header_center_text') }}"
                                            name="header_center_text" class="input-text single-input-text" id="dynamic_header_center_text"
                                            autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Header Right Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('header_right_text') }}"
                                            name="header_right_text" class="input-text single-input-text" id="dynamic_header_right_text"
                                            autofocus required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Body Text<span class="must"> *</span></label>

                                    <div class="single-input-modal">
                                        <textarea name="body_text" class="
                                        single-input-text" id="dynamic_body_text" cols="30" rows="10" value="{{ old('body_text') }}">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Footer Left Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('footer_left_text') }}"
                                            name="footer_left_text" class="input-text single-input-text" id="dynamic_footer_left_text"
                                            autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Footer Center Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('footer_center_text') }}"
                                            name="footer_center_text" class="input-text single-input-text" id="dynamic_footer_center_text"
                                            autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Footer Right Text</label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('footer_right_text') }}"
                                            name="footer_right_text" class="input-text single-input-text" id="dynamic_footer_right_text"
                                            autofocus required>
                                    </div>
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#student-certificate-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.student-attendances.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'biometric_attendance',
                    name: 'biometric_attendance'
                },
                // {
                //     data: 'attendance_type_id',
                //     name: 'attendance_type_id'
                // },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'status',
                    name: 'status'
                },
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
        // edit function
        $(document).on('click', '.edit-attendance-type', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var biometric_attendance = $(this).data('biometric_attendance');
            // var attendance_type_id = $(this).data('attendance_type_id');
            var date = $(this).data('date');
            var remarks = $(this).data('remarks');
            var is_active = $(this).data('is_active');

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_biometric_attendance').val(biometric_attendance);
            // $('#dynamic_attendance_type_id').val(attendance_type_id);
            $('#dynamic_date').val(date);
            $('#dynamic_remarks').val(remarks);

            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // If the form has an ID input field
            $('#studentCertificateForm').attr('action', '{{ route('admin.student-attendances.update', '') }}' +
                '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createAttendanceType').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
