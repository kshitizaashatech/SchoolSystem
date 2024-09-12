@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">

            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="filterForm" method="POST"
                            action="{{ route('admin.primaryexam-routines.storeexamroutine') }}">
                            @csrf
                            <input type="hidden" name="examination_id" value="{{ $examinations->id }}">
                            <div class="row">
                                <div class=" col-lg-3 col-sm-3">
                                    <label for="class_id">Class:</label>
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

                                <div class="col-lg-3 col-md-3">
                                    <label for="section_id"> Section:</label>
                                    <div class="form-group select">
                                        <select name="section_id" id="dynamic_section_id"
                                            class="input-text single-input-text">
                                            <option disabled>Select Section</option>
                                        </select>
                                    </div>
                                    @error('section_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <table class="table table-bordered" id="item_table">
                                        <thead>
                                            <tr>
                                                <th class="">Subject<small class="req"> *</small></th>
                                                <th class="">Exam Date<small class="req"> *</small></th>
                                                <th class="">Exam Start Time<small class="req"> *</small></th>
                                                <th class="">Duration<small class="req"> *</small></th>
                                                <th class="">Credit Hours<small class="req"> *</small></th>
                                                <th class="">Room No.<small class="req"> *</small></th>
                                                <th class="tddm150">Marks (Max..)<small class="req"> *</small></th>
                                                <th class="tddm150">Marks (Min..)<small class="req"> *</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Dynamically fetching the data here with script  --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-success" id="submit">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="examroutine-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                {{-- <th>Id</th> --}}
                                                <th class="">Class</th>
                                                <th class="">Section</th>
                                                <th class="">Subject Group</th>
                                                {{-- <th>Class</th>
                                                <th>Full Marks</th>
                                                <th>Pass Marks</th>
                                                <th>Created At</th>
                                                <th>Status</th> --}}
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
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#examroutine-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.primaryexaminationroutines.get', ['id' => $examinations->id]) }}',
                    type: 'POST'
                },
                columns: [{
                        data: 'class_name',
                        name: 'class_name'
                    },
                    {
                        data: 'section_name',
                        name: 'section_name'
                    },
                    {
                        data: 'subject_group_id',
                        name: 'subject_group_id'
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
        });


        // SEARCH BUTTON CLICK EVENT
        $('#searchButton').on('click', function() {
            dataTable.order([
                [4, 'asc']
            ]).ajax.reload();
        });

        // Attach change event handler to the class dropdown
        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();
            // Fetch sections based on the selected class ID
            fetchSections(classId);
        });

        // Define a function to fetch sections based on class ID
        function fetchSections(classId) {
            $.ajax({
                url: '{{ url('admin/get-section-by-class') }}/' + classId,
                type: 'GET',
                success: function(data) {
                    // Clear existing options in the section select dropdown
                    $('select[name="section_id"]').empty();
                    // Add the default option
                    $('select[name="section_id"]').append(
                        '<option disabled selected>Select Section</option>');
                    // Add new options based on the fetched sections
                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append('<option value="' + key +
                            '">' + value + '</option>');
                    });
                    // Trigger change event on section dropdown to fetch subjects for the selected section
                    $('select[name="section_id"]').trigger('change');
                }
            });
        }

        // Attach change event handler to the section dropdown
        $('select[name="section_id"]').change(function() {
            // Get the selected section ID
            var sectionId = $(this).val();
            // Get the selected class ID
            var classId = $('select[name="class_id"]').val();
            // Fetch subjects based on the selected class ID and section ID
            fetchSubjects(classId, sectionId);
        });

        // Define a function to fetch subjects based on class ID and section ID
        function fetchSubjects(classId, sectionId) {
            $.ajax({
                url: '{{ url('admin/get-subject-group-by-class-and-section') }}',
                type: 'GET',
                data: {
                    class_id: classId,
                    sections: [sectionId]
                },
                success: function(data) {
                    // Clear existing rows in the table body
                    $('#item_table tbody').empty();

                    // Iterate over fetched subject groups and their associated subjects
                    $.each(data, function(index, subjectGroup) {
                        $.each(subjectGroup.subjects, function(key, subject) {
                            // Create a new row for each subject
                            var newRow = $('<tr>');

                            // Append hidden input fields for subject_group_id and subject_id
                            newRow.append(
                                '<input type="hidden" name="subject_group_id[]" value="' +
                                subjectGroup.id + '">');
                            newRow.append(
                                '<input type="hidden" name="subject_id[]" value="' +
                                subject.id + '">');

                            // Append cells with subject information to the new row
                            newRow.append('<td>' + subject.subject + '</td>');
                            newRow.append(
                                '<td><input class="form-control" name="exam_date[]" type="text" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="exam_time[]" type="text" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="exam_duration[]" type="text" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="credit_hour[]" type="text" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="room_no[]" type="text" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="full_marks[]" type="number" value="" required></td>'
                            );
                            newRow.append(
                                '<td><input class="form-control" name="pass_marks[]" type="number" value="" required></td>'
                            );

                            // Append the new row to the table body
                            $('#item_table tbody').append(newRow);
                        });
                    });
                }
            });
        }
    </script>
@endsection
