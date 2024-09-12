@extends('backend.layouts.master')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.fee_due.partials.action')
        </div>


        <form id="FilterForm">
            <div class="col-md-12 col-lg-12 d-flex justify-content-between">
                <label>Available Fee Group<span class="must">*</span></label>
                <div class="col-sm-10">
                    @foreach ($feegroup as $group)
                        <div class="form-check">
                            <input class="form-check-input fee-group-checkbox" type="checkbox" name="fee_groups[]"
                                id="dynamic_fee_groups_{{ $group->id }}" value="{{ $group->id }}"
                                {{ isset($selectedFeeGroups) && in_array($group->id, $selectedFeeGroups) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dynamic_fee_groups_{{ $group->id }}">
                                {{ $group->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('fee_groups')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
            <div class=" col-lg-3 col-sm-3 mt-2">
                <label for="class_id"> Class:</label>
                <div class="select">
                    <select name="class_id">
                        <option value="">Select Class</option>
                        @foreach ($classmanagement as $class)
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
            <!-- Add the Search button -->
            <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                <button type="button" class="btn btn-primary" id="searchButton">Search</button>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="feeDue-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th scope="col">Class</th>
                                                <th scope="col">Section</th>
                                                <th scope="col">Admission Number</th>
                                                <th scope="col">Student Name</th>
                                                <th scope="col">Fees Group</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Paid Amount</th>
                                                <th scope="col">Due Amount</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"></th>
                                                <td></td>
                                            </tr>
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


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                // Set up AJAX headers with the CSRF token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Get values from form inputs
                var classId = $('select[name="class_id"]').val();
                var sectionId = $('select[name="section_id"]').val();
                var feeGroupsID = []; // Initialize as an empty array

                // Get all selected fee group IDs
                $('input[name="fee_groups[]"]:checked').each(function() {
                    feeGroupsID.push($(this).val());
                });
                if (feeGroupsID.length === 0) {
                    alert('Please select at least one fee group.');
                    return;
                }


                // AJAX POST request
                $.ajax({
                    url: "{{ route('admin.fee-dues') }}",
                    type: 'POST',
                    data: {
                        classId: classId,
                        sectionId: sectionId,
                        feeGroupsID: feeGroupsID
                    },

                    success: function(data) {
                        console.log('Ajax Request Success:', data); // Debugging line

                        $('.table-responsive tbody').empty();

                        $.each(data, function(key, value) {
                            var rowHtml = '<tr>';
                            rowHtml += '<td>' + (value.class_name || '') + '</td>';
                            rowHtml += '<td>' + (value.section_name || '') + '</td>';
                            rowHtml += '<td>' + (value.admission_no || '') + '</td>';
                            rowHtml += '<td>' + (value.f_name || '') + ' ' + (value
                                .l_name || '') + '</td>';

                            rowHtml += '<td>';
                            if (value.fee_groups && value.fee_groups.length > 0) {
                                var isValidGroup = value.fee_groups.every(function(
                                    feeGroup) {
                                    return validFeeGroupIds.includes(feeGroup
                                        .id);
                                });

                                if (isValidGroup) {
                                    var feeGroupNames = value.fee_groups.map(function(
                                        feeGroup) {
                                        return feeGroup.name || '';
                                    }).join(', ');
                                    rowHtml += feeGroupNames;
                                } else {
                                    rowHtml += 'Invalid fee group selected';
                                }
                            }
                            rowHtml += '</td>';

                            rowHtml += '</td>';

                            rowHtml += '<td>' + (value.total_fee || '') + '</td>';
                            rowHtml += '<td>' + (value.total_paid || '') + '</td>';
                            rowHtml += '<td>' + (value.fee_due_amount || '') + '</td>';
                            rowHtml +=
                                '<td><button class="btn btn-primary">Add Fees</button>';
                            rowHtml += '</tr>';

                            $('.table-responsive tbody').append(rowHtml);
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Ajax Request Error:', textStatus, errorThrown);
                    }

                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
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
                            '<option disabled>Select Section</option>');

                        // Add new options based on the fetched sections
                        $.each(data, function(key, value) {
                            $('select[name="section_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
@endsection
