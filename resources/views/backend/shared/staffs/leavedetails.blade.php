@extends('backend.layouts.master')
@section('title', 'Add Leave Details')
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $leave }}</h2>
            </div>
            @include('backend.shared.staffs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="box box-info" style="padding:5px;">
                                <div class="box-header with-border">
                                    <div class="pull-right box-tools">
                                        <!-- Removed unnecessary button -->
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <form action="{{ route('admin.staffs.leavedetails.store') }}" id="employeeform"
                                        name="employeeform" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="staff_id">Staff ID</label>
                                            <input type="text" name="staff_id" id="staff_id" class="form-control" value="{{ $staffId }}" readonly>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <h5>Leave Detail:</h5>
                                        <div class="hr-line-dashed"></div>
                                        <div class="col-md-12 col-lg-12 d-flex flex-wrap justify-content-between gap-1">
                                            <div class="col-lg-3 col-sm-3">
                                                <label for="medical_leave">Medical Leave</label>
                                                <input type="text" name="medical_leave"
                                                    value="{{ old('medical_leave') }}" class="form-control"
                                                    id="medical_leave" placeholder="Enter medical leave" required>
                                                @error('medical_leave')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                <label for="casual_leave">Casual Leave</label>
                                                <input type="text" name="casual_leave" value="{{ old('casual_leave') }}"
                                                    class="form-control" id="casual_leave" placeholder="Enter casual leave" required>
                                                @error('casual_leave')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="pull-right box-tools">
                                            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
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
    <script>
        // Assuming you have a JavaScript function to automatically fill the staff_id field
        function fillStaffId() {
            var staffId = "{{ $staffId }}"; // Get the staff ID from PHP variable
            document.getElementById('staff_id').value = staffId;
        }
        // Assuming you have some event (e.g., onchange) to trigger the function
        document.addEventListener('DOMContentLoaded', function() {
            fillStaffId(); // Automatically fill the staff_id field when the page loads
        });
    </script>
@endsection







