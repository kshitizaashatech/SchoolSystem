@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.class_time_table.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="class-time-table-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Day</th>
                                                <th>Time From</th>
                                                <th>Time To</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Room No</th>
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

        <div class="modal fade" id="createClasstimetable" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Class Time Table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="classTimeTblTypeForm"
                            action="{{ route('admin.class-timetables.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">

                                <div class="p-2 label-input">
                                    <label>Day <span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('day') }}" name="day" class="input-text single-input-text"
                                            id="dynamic_day" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Time From<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="date" value="{{ old('time_from') }}" name="time_from"
                                            class="input-text single-input-text" id="dynamic_time_from" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Time To <span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="date" value="{{ old('time_to') }}" name="time_to" class="single-input-text "
                                            id="dynamic_time_to" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Start Time</label>
                                    <div class="single-input-modal">
                                        <input type="date" value="{{ old('start_time') }}" name="start_time"
                                            class="input-text single-input-text" id="dynamic_start_time">
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>End Time</label>
                                    <div class="single-input-modal">
                                        <input type="date" value="{{ old('end_time') }}" name="end_time"
                                            class="input-text single-input-text" id="dynamic_end_time">
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Room No <span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('room_no') }}" name="room_no" class="input-text single-input-text"
                                            id="dynamic_room_no" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_active" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_active" id="option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2">Inactive</label>
                                        </div>
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
        $('#class-time-table-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.class-timetables.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                // {
                //     data: 'leave_type_id',
                //     name: 'leave_type_id'
                // },
                {
                    data: 'day',
                    name: 'day'
                },
                {
                    data: 'time_from',
                    name: 'time_from'
                },
                {
                    data: 'time_to',
                    name: 'time_to'
                },
                {
                    data: 'start_time',
                    name: 'start_time'
                },
                {
                    data: 'end_time',
                    name: 'end_time'
                },
                {
                    data: 'room_no',
                    name: 'room_no'
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
        $(document).on('click', '.edit-class-time', function() {
            var id = $(this).data('id');
            // var leave_type_id = $(this).data('leave_type_id');
            var day = $(this).data('day');
            var time_from = $(this).data('time_from');
            var time_to = $(this).data('time_to');
            var start_time = $(this).data('start_time');
            var end_time = $(this).data('end_time');
            var room_no = $(this).data('room_no');
            var is_active = $(this).data('is_active');

            // Set values in the modal form
            $('#dynamic_id').val(id);
            // $('#dynamic_leave_type_id').val(leave_type_id);
            $('#dynamic_day').val(day);
            $('#dynamic_time_from').val(time_from);
            $('#dynamic_time_to').val(time_to);
            $('#dynamic_start_time').val(start_time);
            $('#dynamic_end_time').val(end_time);
            // $('#dynamic_status').val(status);
            $('#dynamic_room_no').val(room_no);
            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // If the form has an ID input field
            $('#classTimeTblTypeForm').attr('action', '{{ route('admin.class-timetables.update', '') }}' + '/' +
                id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createClasstimetable').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
