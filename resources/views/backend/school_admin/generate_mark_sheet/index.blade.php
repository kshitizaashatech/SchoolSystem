@extends('backend.layouts.master')

@section('style')
    <style>
        @import url('https://fonts.cdnfonts.com/css/algeria');

        :root {
            --input-color: rgb(39, 60, 223);
        }

        .s_name,
        .s_exam,
        .s_estd,
        .s_sheet {
            font-family: "Times New Roman", Times, serif;
            font-size: 25px;
            font-weight: bolder;
        }

        .s_address,
        .s_state {
            font-family: "Times New Roman", Times, serif;
            font-size: 15px;
            font-weight: bolder;
        }

        .gradesheet {
            border: 5px solid var(--input-color);
        }

        .gradesheet_design {
            border: 2px solid var(--input-color);
            padding: 20px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .gradesheet_logo {
            margin-top: 55px;
            height: 150px;
        }

        .s_name,
        .s_address,
        .s_state,
        .s_estd,
        .s_exam,
        .s_sheet,
        .input,
        .first-input,
        .interval-grades,
        .one-credit,
        .foot-input {
            color: var(--input-color);
        }

        .foot-input {
            border-top: 1px dashed var(--input-color);
        }

        .one-credit {
            line-height: 30px;
        }

        .interval-grades {
            height: 40px;
            line-height: 1px;
        }

        .output {
            border-bottom: 1px dashed var(--input-color);
        }

        .first-input {
            font-weight: bold;
        }

        .first-input,
        .output {
            padding: 0px 0px;
            height: 25px;
        }

        .credit,
        .grade {
            border: 1px solid red;
            width: 10px;
        }

        .s_sheet {
            font-family: 'Algeria', sans-serif;
            font-size: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
        </div>
        
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
                            <option disabled selected>Select Section</option>
                        </select>
                    </div>
                    @error('section_id')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="col-lg-3 col-sm-3 mt-2">
                    <label for="marksheet_design_id">Marksheet Design:</label>
                    <div class="select">
                        <select name="marksheet_design_id">
                            <option value="">Select Marksheet Design</option>
                            @foreach ($marksheet_designs as $design)
                                <option value="{{ $design->id }}">{{ $design->template }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-3 mt-2">
                    <label for="examination_id">Examination:</label>
                    <div class="select">
                        <select name="examination_id">
                            <option value="">Select Examination</option>
                            @foreach ($examination as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->exam }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
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
                                    <table id="student-table" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                        <button id="bulk-download-btn" class="btn btn-primary mt-3" style="display: none;">Bulk Download</button>
                                        <thead>
                                            <tr>
                                                <th>
                                                   Select All <input type="checkbox" id="select-all-checkbox">
                                                </th>
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
                </div>
            </div>
        </div>

        <div id="ajax_response"></div>
    </div>
    @endsection
    @section('scripts')
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
            url: '{{ url('admin/generate-marksheets/student/get') }}',
            type: 'post',
            data: function(d) {
                d.class_id = $('select[name="class_id"]').val();
                d.section_id = $('select[name="section_id"]').val();
                d.marksheet_design_id = $('select[name="marksheet_design_id"]').val();
                d.examination_id = $('select[name="examination_id"]').val();
            },
            error: function (xhr, error, thrown) {
                console.error('DataTables AJAX error:', error);
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return '<input type="checkbox" class="student-checkbox" data-student-id="' + row.id + '">';
                },
                orderable: false,
                searchable: false
            },
            {data: 'id', name: 'id'},
            {data: 'f_name', name: 'f_name'},
            {data: 'l_name', name: 'l_name'},
            {data: 'class_id', name: 'class_id'},
            {data: 'roll_no', name: 'roll_no', orderable: true},
            {data: 'father_name', name: 'father_name'},
            {data: 'mother_name', name: 'mother_name'},
            {data: 'guardian_is', name: 'guardian_is'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'actions',
                name: 'actions',
                render: function(data, type, full, meta) {
                    return `
                        <a href="#" class="show-mark-sheet-design" 
                        data-student-id="${full.id}" 
                        data-class-id="${full.class_id}" 
                        data-section-id="${full.section_id}" 
                        data-marksheet-design-id="${$('select[name="marksheet_design_id"]').val()}" 
                        data-examination-id="${$('select[name="examination_id"]').val()}">
                        <i class="fas fa-eye" title="Show"></i>
                        </a>
                        |
                        <a href="#" class="download-mark-sheet" 
                        data-student-id="${full.id}" 
                        data-class-id="${full.class_id}" 
                        data-section-id="${full.section_id}" 
                        data-marksheet-design-id="${$('select[name="marksheet_design_id"]').val()}" 
                        data-examination-id="${$('select[name="examination_id"]').val()}">
                        <i class="fas fa-download" title="Download"></i>
                        </a>`;
                }
            }
        ],
        drawCallback: function(settings) {
            console.log('DataTables draw callback', settings);
        }
    });

    $('#select-all-checkbox').on('change', function() {
        $('.student-checkbox').prop('checked', this.checked);
        updateBulkDownloadButton();
    });

    $(document).on('change', '.student-checkbox', function() {
        updateBulkDownloadButton();
    });

    function updateBulkDownloadButton() {
        var anyChecked = $('.student-checkbox:checked').length > 0;
        $('#bulk-download-btn').toggle(anyChecked);
    }

    $('#bulk-download-btn').on('click', function() {
        var selectedStudentIds = $('.student-checkbox:checked').map(function() {
            return $(this).data('student-id');
        }).get();

        var classId = $('select[name="class_id"]').val();
        var sectionId = $('select[name="section_id"]').val();
        var marksheetDesignId = $('select[name="marksheet_design_id"]').val();
        var examinationId = $('select[name="examination_id"]').val();


        alert('Preparing marksheets for download. This may take a moment...');

        $.ajax({
            url: '{{ route("admin.bulk.download.marksheets") }}',
            type: 'POST',
            data: {
                student_ids: selectedStudentIds.join(','),
                class_id: classId,
                section_id: sectionId,
                marksheet_design_id: marksheetDesignId,
                examination_id: examinationId
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'bulk_marksheets.zip';
                link.click();
                alert('Download completed successfully!');
            },
            error: function(xhr, status, error) {
                console.error('Error downloading marksheets:', error);
                alert('An error occurred while downloading the marksheets. Please try again.');
            }
        });
    });

    $('#searchButton').on('click', function() {
        dataTable.order([[4, 'asc']]).ajax.reload();
    });

    $(document).on('click', '.show-mark-sheet-design', function(e) {
        e.preventDefault();

        var studentId = $(this).data('student-id');
        var classId = $(this).data('class-id');
        var sectionId = $(this).data('section-id');
        var marksheetDesignId = $(this).data('marksheet-design-id');
        var examinationId = $(this).data('examination-id');

        var url = '{{ route("admin.show.marksheet.design", [":student_id", ":class_id", ":section_id", ":marksheetdesign_id", ":examination_id"]) }}';
        url = url.replace(':student_id', studentId)
                 .replace(':class_id', classId)
                 .replace(':section_id', sectionId)
                 .replace(':marksheetdesign_id', marksheetDesignId)
                 .replace(':examination_id', examinationId);

        window.location.href = url;
    });

    $(document).on('click', '.download-mark-sheet', function(e) {
        e.preventDefault();

        var studentId = $(this).data('student-id');
        var classId = $(this).data('class-id');
        var sectionId = $(this).data('section-id');
        var marksheetDesignId = $(this).data('marksheet-design-id');
        var examinationId = $(this).data('examination-id');

        alert('Preparing marksheet for download. This may take a moment...');

        var url = '{{ route("admin.downloadstudentmarksheet.get", [":student_id", ":class_id", ":section_id", ":marksheetdesign_id", ":examination_id"]) }}';
        url = url.replace(':student_id', studentId)
                 .replace(':class_id', classId)
                 .replace(':section_id', sectionId)
                 .replace(':marksheetdesign_id', marksheetDesignId)
                 .replace(':examination_id', examinationId);

        window.location.href = url;
    });
});
</script>
 {{-- SCRIPT FOR GETTING CLASS AND SECTION --}}
 <script>
    $('select[name="class_id"]').change(function() {
        var classId = $(this).val();
        console.log('Selected Class ID:', classId);
        $.ajax({

            url: '/admin/generate-marksheets/get-sections/' + classId,
            type: 'GET',
            success: function(data) {
                console.log('Sections Data:', data);
                $('select[name="section_id"]').empty();
                $('select[name="section_id"]').append('<option disabled>Select Section</option>');
                $.each(data, function(key, value) {
                    $('select[name="section_id"]').append('<option value="' + key + '">' +
                        value + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sections:', error);
            }
        });
    });
</script>

@endsection