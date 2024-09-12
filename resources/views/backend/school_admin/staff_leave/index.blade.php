@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.student_leave.partials.action')
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
                                                <th>Leave Type</th>
                                                <th>Staff Name</th>
                                                <th>Employee Id</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                {{-- <th>Apply Date</th> --}}
                                                <th>Leave Days</th>
                                                <th>Status</th>
                                                <th>Docs</th>
                                                <th>Reason</th>
                                                <th>Approved By</th>
                                                <th>Approved Date</th>
                                                {{-- <th>Remarks</th> --}}
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Staff Leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="leaveTypeForm" action="{{ route('admin.staff-leaverequests.store') }} "
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12 col-lg-12 col-sm-12 d-flex flex-wrap gap-5">
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label for="staff_id">Leave Applied By:</label>
                                        <div class="select">

                                            <select name="staff_id" id="staff_id" class="input-text single-input-text">
                                                <option value="">Select Staff</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->user->f_name }}
                                                        ({{ $staff->employee_id }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 mt-2">
                                        <label for="leave_type_id">Leave Type:</label>
                                        <div class="select">

                                            <select name="leave_type_id" id="leave_type_id"
                                                class="input-text single-input-text">
                                                <option value="">Select Leave Type</option>
                                                @foreach ($leave_type as $class)
                                                    <option value="{{ $class->id }}">{{ $class->type }}</option>
                                                @endforeach
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

                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end">
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
                url: '{{ route('admin.staff-leaverequests.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'leave_type',
                    name: 'leave_type'
                },
                {
                    data: 'staff_name',
                    name: 'staff_name'
                },
                {
                    data: 'staff_employee_id',
                    name: 'staff_employee_id'
                },
                {
                    data: 'from_date',
                    name: 'from_date'
                },

                {
                    data: 'to_date',
                    name: 'to_date'
                },

                {
                    data: 'leave_days',
                    name: 'leave_days'
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
                    data: 'approved_user',
                    name: 'approved_user'
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

        // edit function
        $(document).on('click', '.edit-leave-type', function() {
            document.getElementById("exampleModalLabel").innerHTML = "Update Staff Leave";

            var id = $(this).data('id');
            var leave_type_id = $(this).data('leave_type_id');
            var from_date = $(this).data('from_date');
            var to_date = $(this).data('to_date');
            var classId = $(this).data('class_id');
            var sectionId = $(this).data('section_id');
            var staffId = $(this).data('staff_id');
            var status = $(this).data('status');
            var docs = $(this).data('docs');
            var reason = $(this).data('reason');
            var approved_by = $(this).data('approved_by');
            var approved_date = $(this).data('approved_date');
            var remarks = $(this).data('remarks');
            // var request_type = $(this).data('request_type');

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#leave_type_id').val(leave_type_id);
            $('#nepali-datepicker').val(from_date);
            $('#nepali-datepicker2').val(to_date);
            $('#staff_id').val(staffId).trigger('change');
            // $('#dynamic_docs').val(docs);
            if (status == 1) {
                $('#option1').val(status);
            } else {
                $('#option2').val(status);
            }
            $('#dynamic_docs').val('');

            $('#reason').val(reason);
            $('#remarks').val(remarks);
            // $('#dynamic_request_type').val(request_type);
            // Check the corresponding radio button
            $('input[name="status"]').prop('checked', false);
            $('input[name="status"][value="' + status + '"]').prop('checked', true);
            // If the form has an ID input field
            $('#leaveTypeForm').attr('action', '{{ route('admin.staff-leaverequests.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createLeaveType').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
