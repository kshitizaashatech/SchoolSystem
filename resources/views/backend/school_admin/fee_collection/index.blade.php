@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            {{-- @include('backend.school_admin.fee_collection.partials.action') --}}
        </div>

        <form id="filterForm">
            @csrf
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

            <!-- Add the Search button -->
            <div class="form-group">
                <button type="button" class="btn btn-primary" id="searchButton">Search</button>
            </div>
        </form>

    </div>


    {{-- FOR STUDENT DETAILS --}}
    <div class="feecollectiontable">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">S.N.</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Father Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Admission Number</th>
                    <th scope="col">Class</th>
                    <th scope="col">Section</th>

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




@section('scripts')
    {{-- SELECTING CLASS AND SECTION AND DISPLAYING THE NAME OF STUDENT --}}
    <script>
        $(document).ready(function() {
            // Attach click event handler to the search button
            $('#searchButton').click(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Get the selected class and section IDs
                var classId = $('select[name="class_id"]').val();
                var sectionId = $('select[name="section_id"]').val();
                console.log(classId);
                console.log(sectionId);
                // Fetch students based on the selected class and section IDs
                $.ajax({
                    url: '{{ route('admin.get-studentscollection') }}',
                    type: 'POST',
                    data: {
                        classId: classId,
                        sectionId: sectionId
                    },

                    success: function(data) {
                        console.log('Ajax Request Success:', data);

                        // Clear existing table rows
                        $('.feecollectiontable tbody').empty();

                        // Iterate over the fetched data and append rows to the table
                        $.each(data, function(key, value) {
                            var rowHtml = '<tr>';
                            rowHtml += '<th scope="row">' + (key + 1) +
                                '</th>'; // Assuming you want to display a serial number
                            rowHtml += '<td>' + value.f_name + '</td>';
                            rowHtml += '<td>' + value.l_name + '</td>';
                            rowHtml += '<td>' + value.father_name + '</td>';
                            rowHtml += '<td>' + value.dob + '</td>';
                            rowHtml += '<td>' + value.mobile_number + '</td>';
                            rowHtml += '<td>' + value.admission_no + '</td>';
                            rowHtml += '<td>' + value.class_id + '</td>';
                            rowHtml += '<td>' + value.section_id + '</td>';


                            rowHtml += '</tr>';
                            $('.feecollectiontable tbody').append(rowHtml);
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
