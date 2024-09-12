@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.student.partials.action')
    </div>
    <div class="card mb-2">
        <div class="card-body">
            <form id="filterForm">
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="col-lg-3 col-sm-3 mt-2">
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

                    <div class="col-lg-3 col-sm-3 mt-2">
                        <label for="section_id">Section:</label>
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
                </div>
                <!-- Add the Search button -->
                <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                    <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                </div>
            </form>
        </div>
    </div>

    <button type="button" class="btn btn-success" id="addRollNumbersButton">Add Roll Numbers</button>
    <button type="button" class="btn btn-primary" id="saveRollNumbersButton" style="display: none;">Save Roll Numbers</button>
    <button type="button" class="btn btn-info" id="exportSelectedButton" style="display: none;">Export Selected</button>
    <button type="button" class="btn btn-warning" id="exportAllButton">Export All</button>

    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">
                            <div class="table-responsive">
                                <table id="student-table" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Class</th>
                                            <th>Roll No</th>
                                            <th>Father Name</th>
                                            <th>Mother Name</th>
                                            <th>Guardian Is</th>
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
                <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                    <button type="button" class="btn btn-danger" id="bulkDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Export All Confirmation Modal -->
    <div class="modal fade" id="exportAllModal" tabindex="-1" role="dialog" aria-labelledby="exportAllModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportAllModalLabel">Confirm Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to export all students?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="confirmExportAllButton">Export All</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Bulk Delete Confirmation Modal -->
     <div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete selected students?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmBulkDeleteButton">Delete</button>
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

            var dataTable = $('#student-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('admin/student/get') }}',
                    type: 'post',
                    data: function(d) {
                        d.class_id = $('select[name="class_id"]').val();
                        d.section_id = $('select[name="section_id"]').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'id', name: 'id' },
                    { data: 'f_name', name: 'f_name' },
                    { data: 'l_name', name: 'l_name' },
                    { data: 'class', name: 'class' },
                    { data: 'roll_no', name: 'roll_no' },
                    { data: 'father_name', name: 'father_name' },
                    { data: 'mother_name', name: 'mother_name' },
                    { data: 'guardian_is', name: 'guardian_is' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions' }
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

            $('#searchButton').on('click', function() {
                dataTable.order([
                    [5, 'asc']
                ]).ajax.reload();

                checkExportSelectedVisibility();
            });

            $('#select-all').change(function() {
                $('.student-checkbox').prop('checked', $(this).prop('checked'));
            });

            $('#bulkDeleteButton').on('click', function() {
                var studentIds = [];

                $('.student-checkbox:checked').each(function() {
                    studentIds.push($(this).data('student-id'));
                });

                if (studentIds.length === 0) {
                    alert('Please select at least one student to delete.');
                    return;
                }

                $('#bulkDeleteModal').modal('show');
            });

            $('#confirmBulkDeleteButton').on('click', function() {
                var studentIds = [];

                $('.student-checkbox:checked').each(function() {
                    studentIds.push($(this).data('student-id'));
                });

                $.ajax({
                    url: '{{ route('admin.students.bulk-delete') }}',
                    type: 'POST',
                    data: {
                        studentIds: studentIds
                    },
                    success: function(response) {
                        if (response.success) {
                            dataTable.ajax.reload();
                            alert(response.success);
                        } else {
                            alert('Error deleting students.');
                        }
                        $('#bulkDeleteModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting students:', error);
                        $('#bulkDeleteModal').modal('hide');
                    }
                });
            });
          

            $('#addRollNumbersButton').on('click', function() {
                var studentRows = dataTable.rows().nodes();

                $.each(studentRows, function(index, row) {
                    var studentId = dataTable.row(row).data().id;
                    var currentRollNo = dataTable.row(row).data().roll_no;

                    $(row).find('td:nth-child(6)').html('<input type="text" class="form-control roll-number-input" data-student-id="' + studentId + '" value="' + currentRollNo + '" placeholder="Enter Roll Number">');
                });

                $('#saveRollNumbersButton').show();
            });

            $('#saveRollNumbersButton').on('click', function() {
                var rollNumbers = [];

                $('.roll-number-input').each(function() {
                    var studentId = $(this).data('student-id');
                    var rollNumber = $(this).val().trim();

                    rollNumbers.push({
                        student_id: studentId,
                        roll_number: rollNumber
                    });
                });

                $.ajax({
                    url: '{{ route('admin.students.save-roll-number') }}',
                    type: 'POST',
                    data: {
                        rollNumbers: rollNumbers
                    },
                    success: function(response) {
                        if(response.success) {
                            alert('Roll numbers saved successfully.');
                            dataTable.ajax.reload();
                        } else {
                            alert('Error saving roll numbers.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving roll numbers:', error);
                    }
                });
            });

            $('select[name="class_id"]').change(function() {
                var classId = $(this).val();

                $.ajax({
                    url: 'get-section-by-class/' + classId,
                    type: 'GET',
                    success: function(data) {
                        $('select[name="section_id"]').empty();
                        $('select[name="section_id"]').append('<option disabled>Select Section</option>');

                        $.each(data, function(key, value) {
                            $('select[name="section_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sections:', error);
                    }
                });
            });

            $('select[name="section_id"]').change(checkExportSelectedVisibility);

            function checkExportSelectedVisibility() {
                var classId = $('select[name="class_id"]').val();
                var sectionId = $('select[name="section_id"]').val();
                if (classId && sectionId) {
                    $('#exportSelectedButton').show();
                } else {
                    $('#exportSelectedButton').hide();
                }
            }

            // for export functionality
            $('#exportSelectedButton').on('click', function() {
                var classId = $('select[name="class_id"]').val();
                var sectionId = $('select[name="section_id"]').val();

                if (!classId || !sectionId) {
                    alert('Please select both class and section before exporting.');
                    return;
                }

                window.location.href = '{{ route('admin.students.export-selected') }}?class_id=' + classId + '&section_id=' + sectionId;
            });

            $('#exportAllButton').on('click', function() {
                $('#exportAllModal').modal('show');
            });

            $('#confirmExportAllButton').on('click', function() {
                $('#exportAllModal').modal('hide'); // Close the modal before redirecting
                window.location.href = '{{ route('admin.students.export-all') }}';
            });
        });
    </script>
</div>
@endsection
