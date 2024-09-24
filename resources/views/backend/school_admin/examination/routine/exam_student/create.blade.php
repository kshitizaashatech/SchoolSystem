@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    </div>
    <div class="card mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-lg-3 col-sm-3">
                            <label for="class_id">Class:</label>
                            <input type="text" class="form-control" value="{{ $className }}" disabled>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label for="section_id">Section:</label>
                            <input type="text" class="form-control" value="{{ $sectionName }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-2 ajaxHide" style="display: none">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="scroll-area-fullheight">
                        <div class="studentAllotForm">
                            <form method="post" id="allot_exam_student">
                                @csrf
                                 <!-- Add a hidden input for examination_id -->
                                <input type="hidden" name="examination_id" id="examination_id" value="{{ $examinationId }}">
                                
                                <div class="row mb-2">
                                    <div class="col-sm-12 col-md-12 col-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" id="saveAssignStudents">Assign Students</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="student-table" class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th width="60"><label class="checkbox-inline bolds"><input type="checkbox" class="select_all" autocomplete="off"> All</label></th>
                                                        <th>Admission No</th>
                                                        <th>Student Roll No</th>
                                                        <th>Student Name</th>
                                                        <th>Father Name</th>
                                                        <th>Gender</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="studentTableBody">
                                                    <!-- Student data will be dynamically added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var classId = '{{ $classId }}';
        var sectionId = '{{ $sectionId }}';
        var baseURL = "{{ route('admin.assign-students.by-class-section', ['class_id' => ':class_id', 'section_id' => ':section_id']) }}";

        baseURL = baseURL.replace(':class_id', classId).replace(':section_id', sectionId);

        // Fetch student data immediately after page load
        getAllStudentBasedOnClassSection(classId, sectionId);

        function updateSelectAllCheckbox() {
            var allChecked = $('#studentTableBody input[type="checkbox"]:checked').length ===
                $('#studentTableBody input[type="checkbox"]').length;
            $('.select_all').prop('checked', allChecked);
        }

        function checkboxValuesAndDatas() {
            $('#studentTableBody').on('change', 'input[type="checkbox"]', function() {
                updateSelectAllCheckbox();
            });

            $('.select_all').change(function() {
                var isChecked = $(this).prop('checked');
                $('#studentTableBody input[type="checkbox"]').prop('checked', isChecked);
            });

            $('#studentTableBody input[type="checkbox"]').trigger('change');
        }

        function getAllStudentBasedOnClassSection(classId, sectionId, callback) {
            $.ajax({
                url: baseURL,
                type: 'GET',
                success: function(data) {
                    $('.ajaxHide').css('display', 'block');
                    $('#studentTableBody').empty();

                    if (data && data.length > 0) {
                        $.each(data, function(index, studentData) {
                            var student = studentData;
                            var user = studentData.user;
                            var row = '<tr data-student-id="' + student.id + '">' +
                                '<td><input type="checkbox" name="student_session_id[]" value="' +
                                student.id + '"> </td>' +
                                '<td>' + student.admission_no + '</td>' +
                                '<td>' + student.roll_no + '</td>' +
                                '<td>' + (user ? user.f_name : '') + '</td>' +
                                '<td>' + (user ? user.father_name : '') + '</td>' +
                                '<td>' + (user ? user.gender : '') + '</td>' +
                                '<td>' +
                                '</tr>';

                            $('#studentTableBody').append(row);
                        });

                        updateSelectAllCheckbox();
                    } else {
                        $('#studentTableBody').append(
                            '<tr><td colspan="5">No students found for the selected section</td></tr>'
                        );
                    }
                }
            });

            checkboxValuesAndDatas();

            if (typeof callback === 'function') {
                callback();
            }
        }

        $('#saveAssignStudents').click(function() {
            var classId = '{{ $classId }}';
            var sectionId = '{{ $sectionId }}';
            var examinationId = $('#examination_id').val(); // Get the examination ID

            // Collect checkbox values
            var checkboxValues = [];
            $('input[type="checkbox"][name="student_session_id[]"]:checked').each(function() {
                checkboxValues.push($(this).val());
            });

            // Send an AJAX request to save the data
            $.ajax({
                url: '{{ route('admin.assign-students.save') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    class_id: classId,
                    section_id: sectionId,
                    examination_id: examinationId, // Include the examination ID
                    student_sessions: checkboxValues
                },
                success: function(response) {
                    // Handle success response
                    toastr.success(response.message || 'Assigned successfully');
                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                    toastr.error('Error occurred while assigning exam. Please try again later.');
                }
            });
        });
    });
</script>
@endsection
