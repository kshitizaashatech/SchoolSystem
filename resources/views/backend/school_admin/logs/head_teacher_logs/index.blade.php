@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.logs.head_teacher_logs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="head_teacherlogs_table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                {{-- <th>School ID</th> --}}
                                                <th>Major Incidents</th>
                                                <th>Major Work Observation/Accomplishment/Progress</th>
                                                <th>Assembly Management/ECA/CCA</th>
                                                <th>Miscellaneous</th>
                                                <th>Logged Date</th>
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

        <div class="modal fade" id="createHeadTeacherLogs" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Head Teacher's Log</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="headTeacherLogForm" action="{{ route('admin.headteacher-logs.store') }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label>Record of the Major Incidents</label>
                                    <div class="single-input-modal">
                                        <textarea name="major_incidents" class="input-text single-input-text" id="dynamic_major_incidents" autofocus >{{ old('major_incidents') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Major Work Observation/Accomplishment/Progress</label>
                                    <div class="single-input-modal">
                                        <textarea name="major_work_observation" class="input-text single-input-text" id="dynamic_major_work_observation" autofocus >{{ old('major_work_observation') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Assembly Management/ ECA/ CCA</label>
                                    <div class="single-input-modal">
                                        <textarea name="assembly_management" class="input-text single-input-text" id="dynamic_assembly_management" autofocus >{{ old('assembly_management') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Miscellaneous</label>
                                    <div class="single-input-modal">
                                        <textarea name="miscellaneous" class="input-text single-input-text" id="dynamic_miscellaneous" autofocus>{{ old('miscellaneous') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label for="datetimepicker">Logged Date:</label>
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                            <input id="nepali-datepicker" name="logged_date" type="text"
                                                value="{{ old('logged_date') }}" class="form-control" />

                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Fetch current Nepali date
                                        var currentDate = NepaliFunctions.GetCurrentBsDate();
                            
                                        // Pad month and day with leading zero if they are less than 10
                                        var padZero = function (num) {
                                            return num < 10 ? '0' + num : num;
                                        };
                            
                                        // Format the current date with padded month and day
                                        var formattedDate = currentDate.year + '-' + padZero(currentDate.month) + '-' + padZero(currentDate.day);
                            
                                        // Set the formatted date to the input field
                                        $('#nepali-datepicker').val(formattedDate);
                                    });
                                </script>
                                    
                                        {{-- <div class="p-2 label-input">
                                            <label>Logged Date<span class="must">*</span></label>

                                            <div class="single-input-modal">
                                                <input type="text" value="{{ old('logged_date') }}" name="logged_date"
                                                    class="input-text single-input-text" id="dynamic_logged_date" autofocus
                                                    required>
                                            </div>
                                        </div> --}}


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
<script
src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"
        type="text/javascript"></script>

    <script type="text/javascript">
        $("#nepali-datepicker").nepaliDatePicker();
        $("#nepali-datepicker").nepaliDatePicker({
            container: "#createHeadTeacherLogs",
            dateFormat: "YYYY-MM-DD",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#head_teacherlogs_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.headteacher-logs.get') }}",
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },

                {
                    data: 'major_incidents',
                    name: 'major_incidents'
                },
                {
                    data: 'major_work_observation',
                    name: 'major_work_observation'
                },
                {
                    data: 'assembly_management',
                    name: 'assembly_management'

                },
                {
                    data: 'miscellaneous',
                    name: 'miscellaneous'
                },
                {
                    data: 'logged_date',
                    name: 'logged_date'
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
        //edit funcion
        $(document).on('click', '.edit-headteacher-log', function() {
            // Getting the data attributes
            var id = $(this).data('id');
            var maj_incident = $(this).data('major_incidents');
            var maj_work = $(this).data('major_work_observation');
            var assembly_mgmt = $(this).data('assembly_management');
            var miscellaneous = $(this).data('miscellaneous');
            var logged_date = $(this).data('logged_date');
            console.log(id);
            console.log(maj_incident);
            console.log(maj_work);
            console.log(assembly_mgmt);
            console.log(miscellaneous);
            console.log(logged_date);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            // $('#dynamic_school_id').val(school_id);

            $('#dynamic_major_incidents').val(maj_incident);
            $('#dynamic_major_work_observation').val(maj_work);
            $('#dynamic_assembly_management').val(assembly_mgmt);
            $('#dynamic_miscellaneous').val(miscellaneous);
            $('#nepali-datepicker').val(logged_date);

            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#headTeacherLogForm').attr('action', '{{ route('admin.headteacher-logs.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createHeadTeacherLogs').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
    {{-- @include('backend.includes.nepalidate') --}}
@endsection
@endsection
