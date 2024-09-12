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
                        <form id="filterForm" method="POST" action="{{ route('admin.exam-routines.storeexamroutine') }}">
                            @csrf
                            <input type="hidden" name="examination_id" value="{{ $examinations->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Class</label><small class="req"> *</small>
                                    <div class="form-group select">
                                        <select name="class_id">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Section</label><small class="req"> *</small>
                                    <div class="form-group select">

                                        <select name="section_id" id="dynamic_section_id"
                                            class="input-text single-input-text">
                                            <option disabled>Select Section</option>
                                        </select>
                                        @error('section_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4" id="ajax_response">

                                </div>
                            </div>
                            {{-- <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-success" id="submit">Submit</button>
                            </div> --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createExamMarks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter Marks Obtained By Students</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="examheight100 relative">
                            <div class="marksEntryForm">
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <form method="POST" action="{{ route('admin.exam-results.bulkimport') }}"
                                            enctype="multipart/form-data" id="fileUploadForm">
                                            @csrf
                                            <input type="hidden" name="exam_schedule_id" id="exam_schedule_id"
                                                value="">
                                            <input type="hidden" name="class_id" id="class_id" value="">
                                            <input type="hidden" name="section_id" id="section_id" value="">
                                            <input type="hidden" name="subject_id" id="subject_id" value="">
                                            <input type="hidden" name="exam_id" id="exam_id" value="">
                                            <input type="hidden" name="subject_group_id" id="subject_group_id"
                                                value="">

                                            <div class="input-group mb10">
                                                <div class="dropify-wrapper" style="height: 35.1111px;">
                                                    Import Marks:
                                                    <input id="my-file-selector" name="file" data-height="34"
                                                        class="dropify" type="file">
                                                </div>
                                                <div class="input-group-btn">
                                                    <input type="submit" class="btn btn-sm btn-success mt-2" value="Submit"
                                                        id="btnSubmit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-3">
                                        <a class="btn btn-primary pull-right"
                                            href="{{ asset('sample-files/sample_resultImport.csv') }}" target="_blank"><i
                                                class="fa fa-download"></i> Import Sample</a>
                                    </div>
                                </div>
                                <hr>

                                <form method="post" action="{{ route('admin.students-mark.save') }}" id="student_marks">
                                    @csrf
                                    <div class="row" id="students_details">

                                    </div>
                                </form>
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
                        //$('select[name="section_id"]').trigger('change');
                    }
                });
            }

            // Attach change event handler to the section dropdown
            $('select[name="section_id"]').change(function() {
                console.log("changes here");
                // Get the selected section ID
                var sectionId = $(this).val();
                // Get the selected class ID
                var classId = $('select[name="class_id"]').val();
                var examinationId = $('input[name="examination_id"]').val();
                // Fetch subjects based on the selected class ID and section ID
                fetchSubjects(classId, sectionId, examinationId);
            });

            // Define a function to fetch subjects based on class ID and section ID
            function fetchSubjects(classId, sectionId, examinationId) {
                $.ajax({
                    url: '{{ url('admin/exam-results/get-routine-wise-subject/class-section-and-examination') }}',
                    type: 'GET',
                    data: {
                        class_id: classId,
                        sections: sectionId,
                        examination_id: examinationId
                    },
                    success: function(data) {
                        $('#ajax_response').empty();
                        if (data.message) {
                            alert(data.message);
                        } else {
                            $('#ajax_response').empty();
                            $('#ajax_response').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#ajax_response').empty();
                        if (xhr.status === 400) {
                            var errorMessage = JSON.parse(xhr.responseText).message;
                            toastr.error(errorMessage);
                        } else {

                            toastr.error(
                                'An error occurred while processing your request. Please try again later.'
                            );
                        }
                    }
                });
            }

            // Define a function to fetch student details based on student assigned to examination by class ID and section ID
            function fetchStudentDetails(classId, sectionId, subjectId, examId, examScheduleId) {
                $.ajax({
                    url: '{{ url('admin/exam-results/get-students-by-class-section-subject-and-examination') }}',
                    type: 'POST',
                    data: {
                        class_id: classId,
                        section_id: sectionId,
                        subject_id: subjectId,
                        examination_id: examId,
                        examination_schedule_id: examScheduleId
                    },
                    success: function(data) {
                        console.log("you are here");
                        $('#students_details').empty();
                        if (data.message) {
                            alert(data.message);
                        } else {
                            $('#students_details').empty();
                            $('#students_details').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("you are here");
                        $('#students_details').empty();
                        if (xhr.status === 400) {
                            var errorMessage = JSON.parse(xhr.responseText).message;
                            toastr.error(errorMessage);
                        } else {

                            toastr.error(
                                'An error occurred while processing your request. Please try again later.'
                            );
                        }
                    }
                });
            }

            $(document).on('click', '.assignMarks', function() {

                var examScheduleId = this.dataset.exam_schedule_id;
                var classId = this.dataset.class_id;
                var sectionId = this.dataset.section_id;
                var subjectId = this.dataset.subject_id;
                var examId = this.dataset.exam_id;
                var subjectGroupId = this.dataset.subject_group_id;

                // Assign values to the hidden input fields
                // Assign values to the hidden input fields
                $('#class_id').val(classId);
                $('#section_id').val(sectionId);
                $('#subject_id').val(subjectId);
                $('#exam_id').val(examId);
                $('#subject_group_id').val(subjectGroupId);
                $('#exam_schedule_id').val(examScheduleId);

                fetchStudentDetails(classId, sectionId, subjectId, examId, examScheduleId);
                $('#createExamMarks').modal('show');
            });

            $(document).on('click', '.attendance_chk', function() {
                var isChecked = $(this).prop('checked');

                // Check if the checkbox is checked
                if (isChecked) {
                    $(this).closest('tr').find('.participant_assessment').prop('disabled', true).val(0);
                    $(this).closest('tr').find('.practical_assessment').prop('disabled', true).val(0);
                    $(this).closest('tr').find('.theory_assessment').prop('disabled', false).val(0);
                } else {
                    $(this).closest('tr').find('.participant_assessment').prop('disabled', false).val('');
                    $(this).closest('tr').find('.practical_assessment').prop('disabled', false).val('');
                    $(this).closest('tr').find('.theory_assessment').prop('disabled', false).val('0');
                }
            });


        });
    </script>
@endsection
