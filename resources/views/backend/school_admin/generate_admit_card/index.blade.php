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
        <form id="filterForm">
            @csrf
            <div class="d-flex justify-content-between">
                <div class=" col-lg-3 col-sm-3 mt-2 ">
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

                <div class="col-lg-3 col-sm-3 mt-2 mr-2">
                    <label for="admit_card_id"> Admit Card Design:</label>
                    <div class="select">
                        <select name="admit_card_id">
                            <option value="">Select Admit Card Design</option>
                            @foreach ($admitcard_designs as $design)
                                <option value="{{ $design->id }}">{{ $design->template }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-3 mt-2">
                    <label for="examination_id">Examination Name:</label>
                    <div class="select">
                        <select name="examination_id">
                            <option value="">Select Exam</option>
                            @foreach ($examination as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->exam }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                                    <table id="student-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
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

    </div>

    {{-- FOR MODAL POP --}}
    <div id="ajax_response">

    </div>
    {{-- DOWNLOAD --}}

    <script>
        $('#student-table').on('click', 'a.download-admit-card', function(e) {
            e.preventDefault();

            var studentId = $(this).data('student-id');
            var admitCardId = $(this).data('admit-card-id');
            var examinationId = $(this).data('examination-id');


            // Make an AJAX request to download the admit card
            $.ajax({
                url: '/admin/generate-admitcards/download-admit-card/' + studentId + '/' + admitCardId +
                    '/' + examinationId,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Set the response type to blob
                },
                success: function(response, status, xhr) {
                    var filename = '';
                    var disposition = xhr.getResponseHeader('Content-Disposition');

                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    }

                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });

                    // Create a temporary URL to the blob
                    var url = window.URL.createObjectURL(blob);

                    // Create a temporary link element to trigger the download
                    var link = document.createElement('a');
                    link.href = url;
                    link.download = filename;

                    // Trigger the click event on the link to start the download
                    document.body.appendChild(link);
                    link.click();

                    // Clean up
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(link);



                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
        });
    </script>

    {{-- SHOW --}}
    <script>
        $(document).on('click', '.show-admit-card', function() {
            // Add a click event listener to the "Show" buttons
            // $('#student-table').on('click', 'a.show-admit-card', function(e) {
            // e.preventDefault(); // Prevent the default behavior of the anchor tag

            // Get the student ID from the data attribute of the anchor tag
            var studentId = $(this).data('student-id');
            var admitCardId = $(this).data('admit-card-id');
            var examinationId = $(this).data('examination-id');

            console.log('STUDENT', studentId);
            console.log('ADMIT_CARD', admitCardId);
            console.log('Examination', examinationId);


            // Make an AJAX request to the showAdmitCardDesign route
            $.ajax({
                // url: baseURL + '/admin/admit-carddesign/show-admitcard-design/' + studentId + '/' + admitCardId + '/' + examinationId + '/'+examScheduleId,
                url: baseURL + '/admin/generate-admitcards/show-admitcard-design/' + studentId + '/' +
                    admitCardId + '/' + examinationId,


                type: 'GET',
                data: {
                    student_id: studentId,
                    admit_card_id: admitCardId,
                    examination_id: examinationId,


                },
                success: function(data) {
                    // console.log("hello world");
                    $('#ajax_response').empty();
                    if (data.message) {
                        alert(data.message);
                    } else {
                        $('#ajax_response').empty();
                        $('#ajax_response').html(data);
                    }



                    // Open the modal
                    $('#exampleModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
        });
        // });
    </script>

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
                    url: '{{ url('admin/generate-admitcards/student/get') }}',
                    type: 'post',
                    data: function(d) {
                        d.class_id = $('select[name="class_id"]').val();
                        d.section_id = $('select[name="section_id"]').val();
                        d.admit_card_id = $('select[name="admit_card_id"]').val();
                        d.examination_id = $('select[name="examination_id"]').val();

                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'f_name',
                        name: 'f_name'
                    },
                    {
                        data: 'l_name',
                        name: 'l_name'
                    },
                    {
                        data: 'class_id',
                        name: 'class_id'
                    },
                    {
                        data: 'roll_no',
                        name: 'roll_no',
                        orderable: true
                    },
                    {
                        data: 'father_name',
                        name: 'father_name'
                    },
                    {
                        data: 'mother_name',
                        name: 'mother_name'
                    },
                    {
                        data: 'guardian_is',
                        name: 'guardian_is'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    },




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
            //  // SEARCH BUTTON CLICK EVENT
            $('#searchButton').on('click', function() {

                var classId = $('select[name="class_id"]').val();
                var sectionId = $('select[name="section_id"]').val();
                var examinationId = $('select[name="examination_id"]').val();
                var admitcardDesignId = $('select[name="admitcard_designs_id"]').val();


                // The selected values of all dropdowns
                console.log('Selected Class ID:', classId);
                console.log('Selected Section ID:', sectionId);
                console.log('Selected Examination ID:', examinationId);
                console.log('Selected Admit Card Design ID:', admitcardDesignId);

                dataTable.order([
                    [4, 'asc']
                ]).ajax.reload();
            });

        });
    </script>

    {{-- SCRIPT FOR GETTING CLASS AND SECTION --}}
    <script>
        $('select[name="class_id"]').change(function() {
            var classId = $(this).val();
            console.log('Selected Class ID:', classId);
            $.ajax({
                url: '/admin/generate-admitcards/get-sections/' + classId,
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
