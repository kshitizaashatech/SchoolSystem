@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.examination.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="examination-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                {{-- <th>School ID</th> --}}
                                                <th>Exam</th>

                                                <th>Publish</th>
                                                <th>Rank Generated</th>
                                                <th>Description</th>
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
                </div>
            </div>
        </div>

        <div class="modal fade" id="createExamination" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="examinationForm" action="{{ route('admin.examinations.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">

                            <div class="col-md-12">

                                <div class="p-2 label-input">
                                    <label>Exam<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('exam') }}" name="exam"
                                            class="input-text single-input-text" id="dynamic_exam" autofocus required>
                                    </div>
                                </div>

                                {{-- <div class="p-2 label-input">
                                    <label for="datetimepicker">Date:</label>
                                    <div class="form-group">
                                        <div class="input-group date" id="admission-datetimepicker" data-target-input="nearest">
                                            <input id="nepali-datepicker" name="date" type="text" class="form-control datetimepicker-input" />
                                        </div>
                                    </div>
                                </div> --}}

                                
                                <div class="p-2 label-input">
                                    <label for="datetimepicker">Date:</label>
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                            <input id="nepali-datepicker" name="date" type="text"
                                                value="{{ old('date') }}" class="form-control" />

                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Exam Type<span class="must">*</span></label>

                                    <div class="select">
                                        <select name="exam_type" id="exam_type">
                                            <option disabled selected>Select Exam Type</option>
                                            <option value="terminal">Terminal</option>
                                            <option value="final">Final</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="">
                                    <div class="d-flex justify-content-between label-input">
                                        <label class="d-flex align-items-center mt-2" for="section_id">Section<span
                                                class="must"> *</span></label>
                                    </div>
                                    <div class="hr-line-dashed mt-2"></div>
                                    <div class="checkbox-container">
                                        <div class="termexam_selection">

                                        </div>
                                    </div>
                                </div> --}}

                                <div class="mt-4 label-input term_exam" style="display: none;">
                                    <label>Terminal Examinations<span class="must"> *</span></label>
                                    <div class="checkbox-container">
                                        <div class="termexam_selection">

                                        </div>

                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>publish<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_publish" id="option1_publish"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1_publish">Active</label>

                                            <input type="radio" class="btn-check" name="is_publish" id="option2_publish"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2_publish">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Rank<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_rank_generated"
                                                id="option1_rank" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1_rank">Active</label>

                                            <input type="radio" class="btn-check" name="is_rank_generated"
                                                id="option2_rank" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2_rank">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add hidden input for session_id -->
                                <input type="hidden" name="session_id" value="{{ session('academic_session_id') }}">


                                <div class="p-2 label-input">
                                    <label>Description<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('description') }}" name="description"
                                            class="input-text single-input-text" id="dynamic_description" autofocus
                                            required>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-4 col-xs-12"> --}}
                                <div class="p-2 label-input">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_active" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_active" id="option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>

                                </div>
                            </div>
                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
<script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"></script>

<script>
$(document).ready(function () {

     // Initialize nepali-datepicker
     $("#nepali-datepicker").nepaliDatePicker();
        $("#nepali-datepicker").nepaliDatePicker({
            container: "#createExamination",
            dateFormat: "YYYY-MM-DD",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#examination-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.examinations.get') }}',
            type: 'POST'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'exam', name: 'exam' },
            { data: 'is_publish', name: 'is_publish' },
            { data: 'is_rank_generated', name: 'is_rank_generated' },
            { data: 'description', name: 'description' },
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

   

    $(document).on('click', '.edit-examination', function() {
        $('.termexam_selection').empty();
        $('.term_exam').hide();

        var id = $(this).data('id');
        var exam = $(this).data('exam');
        var date = $(this).data('date');
        var exam_type = $(this).data('exam_type');
        var is_publish = $(this).data('is_publish');
        var is_rank_generated = $(this).data('is_rank_generated');
        var description = $(this).data('description');
        var is_active = $(this).data('is_active');
        var finalTerminalExamination = $(this).data('final_term_examination');

        $('#dynamic_id').val(id);
        $('#nepali-datepicker').val(date);
        $('#dynamic_exam').val(exam);
        $('#exam_type').val(exam_type);
        $('#dynamic_description').val(description);

        // Check the corresponding radio button for is_active
        $('input[name="is_active"]').prop('checked', false);
        $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

        // Check the corresponding radio button for is_publish
        $('input[name="is_publish"]').prop('checked', false);
        $('input[name="is_publish"][value="' + is_publish + '"]').prop('checked', true);

        // Check the corresponding radio button for is_rank_generated
        $('input[name="is_rank_generated"]').prop('checked', false);
        $('input[name="is_rank_generated"][value="' + is_rank_generated + '"]').prop('checked', true);

        if (exam_type == 'final') {
            $('.term_exam').show();
            fetchTerminalExam(id, function() {
                $('input[name="term_exam[]"]').prop('checked', false);
                finalTerminalExamination.forEach(function(exam) {
                    $('#term_exam' + exam.id).prop('checked', true);
                });
            });
        }

        $('#examinationForm').attr('action', '{{ route('admin.examinations.update', '') }}' + '/' + id);
        $('#methodField').val('PUT');

        $('#createExamination').modal('show');

        return false;
    });

    $('select[name="exam_type"]').change(function() {
        $('.termexam_selection').empty();
        $('.term_exam').hide();
        var exam_type = $(this).val();
        if (exam_type == 'final') {
            $('.term_exam').show();
            fetchTerminalExam(exam_type);
        }
    });

    function fetchTerminalExam(id = null, callback) {
        $.ajax({
            url: '{{ url('admin/get-term-examination') }}',
            type: 'GET',
            data: id,
            success: function(data) {
                $('.termexam_selection').empty();
                var checkboxContainer = $('.termexam_selection');
                var inputType = 'checkbox';

                $.each(data, function(key, value) {
                    var checkbox = $('<label class="l-checkbox" for="term_exam' + key +
                        '">' +
                        '<span>' + value + '</span>' +
                        '<input class="section-checkbox" type="' + inputType +
                        '" name="term_exam[]" id="term_exam' +
                        key +
                        '" value="' + key + '">' +
                        '</label>');
                    checkboxContainer.append(checkbox);
                });

                if (typeof callback === 'function') {
                    callback();
                }
            }
        });
    }
});
</script>
@endsection
    
@endsection
