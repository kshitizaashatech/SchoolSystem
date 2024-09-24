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
                        <div class="mt-4" id="ajax_response">
                            <!-- Subject details will be appended here via AJAX -->
                        </div>
                    </div>
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
                                    <form method="POST" enctype="multipart/form-data" id="fileUploadForm" action="{{ route('admin.exam-results.bulkimport') }}">
                                        @csrf
                                        <input type="hidden" name="class_id" id="import_class_id">
                                        <input type="hidden" name="section_id" id="import_section_id">
                                        <input type="hidden" name="subject_id" id="import_subject_id">
                                        <input type="hidden" name="exam_schedule_id" id="import_exam_schedule_id">
                                        <input type="hidden" name="exam_id" id="import_exam_id">

                                        <div class="input-group mb10">
                                            <div class="dropify-wrapper" style="height: 35.1111px;">
                                                Import Marks:
                                                <input id="my-file-selector" name="file" data-height="34" class="dropify" type="file" accept=".csv,.txt">
                                            </div>
                                            <div class="input-group-btn">
                                                <input type="submit" class="btn btn-sm btn-success mt-2" value="Import" id="btnSubmit">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" id="exportAllButton">Export All</button>
                                </div> --}}
                            </div>
                            <hr>
                            <form method="post" action="{{ route('admin.students-mark.save') }}" id="student_marks">
                                @csrf
                                <div id="students_details">
                                    <!-- Student rows will be populated here via AJAX -->
                                </div>
                            </form>
                        </div>
                    </div>
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

    <script>
        $(document).ready(function() {
            var examinationId = '{{ $examinations->id }}';
            var classId = '{{ $classId }}';
            var sectionId = '{{ $sectionId }}';
            var examScheduleId = '{{ $examSchedule }}';
            fetchSubjects(classId, sectionId, examinationId);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                            $('#ajax_response').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#ajax_response').empty();
                        var errorMessage = xhr.status === 400 ? JSON.parse(xhr.responseText).message : 'An error occurred while processing your request. Please try again later.';
                        toastr.error(errorMessage);
                    }
                });
            }

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
                        $('#students_details').empty();
                        if (data.message) {
                            alert(data.message);
                        } else {
                            $('#students_details').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#students_details').empty();
                        var errorMessage = xhr.status === 400 ? JSON.parse(xhr.responseText).message : 'An error occurred while processing your request. Please try again later.';
                        toastr.error(errorMessage);
                    }
                });
            }

            $(document).on('click', '.assignMarks', function() {
                var examScheduleId = this.dataset.exam_schedule_id;
                var classId = this.dataset.class_id;
                var sectionId = this.dataset.section_id;
                var subjectId = this.dataset.subject_id;
                var examId = this.dataset.exam_id;
                $('#createExamMarks').modal('show');
                fetchStudentDetails(classId, sectionId, subjectId, examId, examScheduleId);
            });

            $(document).on('click', '.attendance_chk', function() {
                var isChecked = $(this).prop('checked');
                $(this).closest('tr').find('.participant_assessment, .practical_assessment, .theory_assessment').prop('disabled', isChecked).val(isChecked ? 0 : '');
            });

            // Trigger export confirmation modal
            $('#exportAllButton').on('click', function() {
                $('#exportAllModal').modal('show');
            });

            $('#confirmExportAllButton').on('click', function() {
                $('#exportAllModal').modal('hide'); // Close the modal before redirecting
                window.location.href = '{{ route('admin.exam-results.export-sample') }}';
            });
        });
    
    </script>
@endsection
