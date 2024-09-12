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

            <div class="col-lg-3 col-sm-3 mt-2">
                <label for="marksheet_design_id"> Marksheet Design:</label>
                <select name="marksheet_design_id" class="form-control">
                    <option value="">Select Marksheet Design</option>
                    @foreach($marksheet_designs as $design)
                    <option value="{{ $design->id }}">{{ $design->template }}</option>
                    @endforeach
                </select>
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

    {{-- FOR MODAL POP --}}
<div id="ajax_response">

</div>


{{-- DOWNLOAD --}}
<script>
      $('#student-table').on('click', 'a.download-mark-sheet', function(e) {
            e.preventDefault();

            var studentId = $(this).data('student-id');
            var classId = $(this).data('class-id');
            var sectionId = $(this).data('section-id');
            var marksheetDesignId = $(this).data('marksheet-design-id');

            // Construct the URL for file download
            var url = '/admin/mark-sheetesign/download-marksheet-design/' + studentId + '/' + classId + '/' + sectionId + '/' + marksheetDesignId;

            // Create a temporary link element
            var link = document.createElement('a');
            link.href = url;
            link.download = ''; // Optionally set a default filename here

            // Append the link to the body and trigger a click
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        });
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
                url: '{{ url('admin/student/get') }}',
                type: 'post',
                data: function(d) {
                d.class_id = $('select[name="class_id"]').val();
                d.section_id = $('select[name="section_id"]').val();
                d.marksheet_design_id = $('select[name="marksheet_design_id"]').val();
            }
            },
            columns: [
    {
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
        data: null,
        name: 'action',
        render: function(data, type, full, meta) {
            var markSheetDesignId = $('select[name="marksheet_design_id"]').val();

            var showUrl = '{{ route("admin.exam-results.show", ":id") }}'.replace(':id', full.id);
            var showButton = '<a href="' + showUrl + '" class="btn btn-primary btn-sm show-mark-sheet-design" data-student-id="' + full.id + '" data-class-id="' + full.class_id + '" data-section-id="' + full.section_id + '" data-marksheet-design-id="' + markSheetDesignId + '">Show</a>';

            var downloadButton = '<a href="' +
    '{{ route("admin.downloadmarksheetdesign.get", ["student_id" => ":studentId", "class_id" => ":classId", "section_id" => ":sectionId", "marksheetdesign_id" => ":marksheetDesignId"]) }}' +
    '" class="btn btn-primary btn-sm download-mark-sheet" ' +
    'data-student-id="' + full.id + '" ' +
    'data-class-id="' + full.class_id + '" ' +
    'data-section-id="' + full.section_id + '" ' +
    'data-marksheet-design-id="' + markSheetDesignId + '">Download</a>';
            return showButton + ' ' + downloadButton;
        }
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
     // SEARCH BUTTON CLICK EVENT
    $('#searchButton').on('click', function() {
        dataTable.order([[4, 'asc']]).ajax.reload();
    });

});

    </script>

    {{-- SHOW --}}
{{-- <script>
    $(document).ready(function() {
    // Add a click event listener to the "Show" buttons
    $('#student-table').on('click', 'a.show-mark-sheet-design', function(e) {
        e.preventDefault();
        var studentId = $(this).data('student-id');
        var classId = $(this).data('class-id'); // If needed, you can also use these values
        var sectionId = $(this).data('section-id');
        var marksheetDesignId = $(this).data('marksheet-design-id');

        var url = "{{ route('admin.exam-results.show', ':id') }}".replace(':id', studentId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#ajax_response').html(data);
                $('#markSheetModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching exam result:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                alert('Error fetching exam result. Please check the console for more details.');
            }
        });
    });
});
</script> --}}


{{--  GETTING CLASS AND SECTION --}}
    {{-- <script>

        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();

            console.log('Selected Class ID:', classId);

            // Fetch sections based on the selected class ID
            $.ajax({
                url: 'get-section-by-class/' + classId,
                type: 'GET',
                success: function(data) {
                    console.log('Sections Data:', data);

                    // Clear existing options
                    $('select[name="section_id"]').empty();

                    // Add the default option
                    $('select[name="section_id"]').append('<option disabled>Select Section</option>');

                    // Add new options based on the fetched sections
                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sections:', error);
                }
            });
        });


    </script> --}}

    {{--SCRIPT FOR GETTING CLASS AND SECTION --}}
    <script>
        $('select[name="class_id"]').change(function() {
            var classId = $(this).val();
            console.log('Selected Class ID:', classId);
            $.ajax({

                url: '/admin/students/marksheet/get-sections/' + classId
                , type: 'GET'
                , success: function(data) {
                    console.log('Sections Data:', data);
                    $('select[name="section_id"]').empty();
                    $('select[name="section_id"]').append('<option disabled>Select Section</option>');
                    $.each(data, function(key, value) {
                        $('select[name="section_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
                , error: function(xhr, status, error) {
                    console.error('Error fetching sections:', error);
                }
            });
        });

    </script>



    @endsection
