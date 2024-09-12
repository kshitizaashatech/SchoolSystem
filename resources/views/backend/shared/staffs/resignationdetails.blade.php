@extends('backend.layouts.master')
@section('title', 'Add Resignation Details')
@section('content')
<div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>
                    {{ $resignation }}
                </h2>
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
                            </div>
                            <form action="{{ route('admin.staffs.resignationdetails.store') }}" id="employeeform"
                                        name="employeeform" method="post" enctype="multipart/form-data">
                                        @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="staff_id">Staff ID</label>
                                    <input type="text" name="staff_id" id="staff_id" class="form-control" value="{{ $staffId }}" readonly>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="resignation_letter">Resignation Letter</label>
                                    <input type="text" name="resignation_letter" value="{{ old('resignation_letter') }}" class="form-control" id="resignation_letter" placeholder="Enter resignation_letter" required>
                                    @error('resignation_letter')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                {{-- <div class="form-group col-lg-3 col-sm-3 mt-2">
                                    <label for="note">Note :</label>
                                    <textarea name="note" class="form-control" id="note" placeholder="Note.." rows="15" cols="50">{{ old('note') }}</textarea>
                                    @error('note')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div> --}}
                                <div class="pull-right box-tools">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                                </div>
                            </div>
                        </form>
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