@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.staff_attendance.partials.action')
        </div>

        <!-- Holiday Range Modal -->
        <div class="modal fade" id="holidayRangeModal" tabindex="-1" role="dialog" aria-labelledby="holidayRangeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="holidayRangeModalLabel">Mark Holiday Range</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="holidayStartDate">Start Date:</label>
                            <input type="text" class="form-control" id="holidayStartDate">
                        </div>
                        <div class="form-group">
                            <label for="holidayEndDate">End Date:</label>
                            <input type="text" class="form-control" id="holidayEndDate">
                        </div>
                        <div class="form-group">
                            <label for="holidayReason">Reason:</label>
                            <input type="text" class="form-control" id="holidayReason" placeholder="e.g., Summer Vacation, Dashain Vacation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveHolidayRange">Save Holiday Range</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card">
            <div class="card-body">
                <form id="filterForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Select Role:</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="6">Teacher</option>
                                    <option value="7">Accountant</option>
                                    <option value="8">Librarian</option>
                                    <option value="9">Principal</option>
                                    <option value="10">Receptionist</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 mt-2">
                            <label for="datetimepicker">Date:</label>
                            <div class="form-group">
                                <div class="input-group date" id="admission-datetimepicker" data-target-input="nearest">
                                    <input id="admission-datepicker" name="date" type="text" class="form-control datetimepicker-input" />
                                </div>
                                @error('date')
                                <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Staff Attendance Table -->
        <div id="resultContainer">
            <div class="card mt-2">
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12 col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="saveAttendanceButton">Save Attendance</button>
                                <button type="button" class="btn btn-primary" id="markHolidayButton" style="margin-left: 5px;">Mark Holiday</button>
                                <button type="button" class="btn btn-primary" id="exportDataButton" style="margin-left: 5px;">Export Data</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-12">
                                <div class="report-table-container">
                                    <div class="table-responsive">
                                        <table id="staffTable" class="table table-bordered table-striped dataTable dtr-inline"
                                            aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Staff Name</th>
                                                    <th>Attendance</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody id="staffTableBody">
                                                <!-- Staff attendance data will be appended here by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        @include('backend.includes.nepalidate')

        <script>
            $(document).ready(function() {
                var attendance_types = @json($attendance_types);
    console.log('Attendance types:', attendance_types);

    // Set current Nepali date to the date input field
    var currentDate = NepaliFunctions.GetCurrentBsDate();
    var padZero = function(num) { return num < 10 ? '0' + num : num; };
    var formattedDate = currentDate.year + '-' + padZero(currentDate.month) + '-' + padZero(currentDate.day);
    $('#admission-datepicker').val(formattedDate);

    // Fetch and display all staff details on page load
    getStaffDetails(attendance_types);

    // Fetch and display staff details based on selected role and date
    $('#searchButton').click(function() {
        var role = $('select[name="role"]').val();
        var date = $('#admission-datepicker').val();
        getStaffDetails(attendance_types, role, date);
    });

    function getStaffDetails(attendance_types, role = null, date = null) {
        $.ajax({
            url: '{{ route('admin.get.staff.name') }}',
            type: 'GET',
            data: { role: role, date: date },
            success: function(data) {
                console.log('Received data:', data);
                $('#staffTableBody').empty();
                if (data.original && data.original.length > 0) {
                    $.each(data.original, function(index, staffData) {
                        console.log('Processing staff:', staffData);
                        var staff = staffData.staff;
                        var row = '<tr data-staff-id="' + staff.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + staff.f_name + ' ' + staff.l_name + '</td>' +
                                    '<td>';
                        if (attendance_types) {
                            var attendanceFound = false;
                            $.each(attendance_types, function(i, attendance_type) {
                                var isChecked = false;
                                if (staffData.staff_attendances && staffData.staff_attendances.length > 0) {
                                    isChecked = staffData.staff_attendances[0].attendance_type_id == attendance_type.id;
                                    if (isChecked) {
                                        attendanceFound = true;
                                    }
                                }
                                console.log('Staff ID:', staff.id, 'Attendance type:', attendance_type.id, 'isChecked:', isChecked);
                                row += '<label for="attendance_type_' + staff.id + '_' + attendance_type.id + '" class="attendance-radio l-radio">' +
                                            '<input type="radio" name="attendance_type_id[' + staff.id + ']" value="' + attendance_type.id + '" id="attendance_type_' + staff.id + '_' + attendance_type.id + '" ' + (isChecked ? 'checked' : '') + '> ' +
                                            '<span>' + attendance_type.type + '</span>' +
                                        '</label>';
                            });
                            if (!attendanceFound) {
                                console.log('No saved attendance found for staff ID:', staff.id, '. Defaulting to Present.');
                            }
                        } else {
                            row += 'Attendance types not available';
                        }
                        row += '</td>' +
                                '<td><input type="text" name="remarks[' + staff.id + ']" value="' + (staffData.staff_attendances && staffData.staff_attendances.length > 0 ? staffData.staff_attendances[0].remarks : '') + '"></td>' +
                               '</tr>';

                        $('#staffTableBody').append(row);
                    });
                    $('#saveAttendanceButton').show();
                } else {
                    $('#staffTableBody').append('<tr><td colspan="4">No staff members found for the selected role and date</td></tr>');
                    $('#saveAttendanceButton').hide();
                }
            },
            error: function(error) {
                console.error('Error fetching staff details:', error);
            }
        });
    }
                function populateExistingAttendance(staffMembers) {
                    $.each(staffMembers, function(index, staffData) {
                        var staff = staffData.staff;
                        if (staffData.staff_attendances && staffData.staff_attendances.length > 0) {
                            $.each(staffData.staff_attendances, function(i, attendance) {
                                var attendanceTypeId = attendance.attendance_type_id;
                                $('input[name="attendance_type_id[' + staff.staff_id + ']"][value="' + attendanceTypeId + '"]').prop('checked', true);
                                $('input[name="remarks[' + staff.staff_id + ']"]').val(attendance.remarks);
                            });
                        }
                    });
                }

                // Mark holiday for selected staff
                $('#markHolidayButton').click(function() {
                    $('input[type="radio"][value="4"]').prop('checked', true);
                });

                

                // Save attendance data
                $('#saveAttendanceButton').click(function() {
                    var role = $('select[name="role"]').val();
                    var date = $('#admission-datepicker').val();
                    var attendanceData = [];
                    $('#staffTable tbody tr').each(function() {
                        var staffId = $(this).data('staff-id');
                        var attendanceTypeId = $('input[name="attendance_type_id[' + staffId + ']"]:checked').val();
                        var remarks = $('input[name="remarks[' + staffId + ']"]').val();
                        if (attendanceTypeId) { // Check if an attendance type is selected
                            attendanceData.push({
                                staff_id: staffId,
                                attendance_type_id: attendanceTypeId,
                                date: date,
                                remarks: remarks
                            });
                        }
                    });

                    // Send an AJAX request to save the staff attendance data
                    $.ajax({
                        url: 'staff-attendances/save-attendance',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            role: role,
                            attendance_data: attendanceData
                        },
                        success: function(response) {
                            if (response.message) {
                                toastr.success(response.message);
                            } else {
                                toastr.success('Attendance saved successfully');
                            }
                        },
                        error: function(error) {
                            console.error(error);
                            toastr.error('Error occurred while saving attendance. Please try again later.');
                        }
                    });
                });

                // Initialize date pickers for the holiday range modal
    $('#holidayStartDate, #holidayEndDate').nepaliDatePicker()
    $("#holidayStartDate").nepaliDatePicker({
    container: "#holidayRangeModal",
    dateFormat: "YYYY-MM-DD",
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 200,
    onChange: function() {
        $(this).change();
    }
});

$("#holidayEndDate").nepaliDatePicker({
    container: "#holidayRangeModal",
    dateFormat: "YYYY-MM-DD",
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 200,
    onChange: function() {
        $(this).change();
    }
});

// Open the holiday range modal
$('#markHolidayRangeButton').click(function() {
    $('#holidayRangeModal').modal('show');
});

// Handle saving the holiday range
$('#saveHolidayRange').click(function() {
    var startDate = $('#holidayStartDate').val();
    var endDate = $('#holidayEndDate').val();
    var reason = $('#holidayReason').val();

    if (!startDate || !endDate) {
        toastr.warning('Please select both start and end dates.');
        return;
    }

    if (confirm('Are you sure you want to mark holidays from ' + startDate + ' to ' + endDate + '?')) {
        $.ajax({
            url: '{{ route("admin.staff.mark-holiday-range") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { 
                start_date: startDate, 
                end_date: endDate,
                reason: reason
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#holidayRangeModal').modal('hide');
                    // Optionally, update UI or refresh data
                } else {
                    toastr.error(response.message || 'Error marking holiday range.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error details:', xhr.responseText);
                toastr.error('Error marking holiday range. Please check the console for details.');
            }
        });
    }
});


            });
        </script>
    @endsection
@endsection



