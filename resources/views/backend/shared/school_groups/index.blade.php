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
            @include('backend.shared.school_groups.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="school-groups-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
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

        {{-- ===================================================================
                        ADD SCHOOL GROUP MODAL
        =================================================================== --}}
        <div class="modal fade" id="createSchoolGroups" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add School Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="schoolGroupsForm" action="{{ route('admin.school-groups.store') }}">
                            @csrf
                            <div class="col-md-12 col-xs-12">
                                <div class="p-2 label-input">
                                    <label>Name<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input id="createInput" type="text" name="name"
                                            class="input-text single-input-text" autofocus required
                                            onkeyup="replaceFunction(this.value)" placeholder="Type your school group..">
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Schools</label>
                                    <div class="single-input-modal">
                                        @foreach ($schools as $school)
                                            <div class="form-check">
                                                <input class="form-check-input school-checkbox" type="checkbox"
                                                    name="schools[]" id="school_{{ $school->id }}"
                                                    value="{{ $school->id }}" {{ $school->group ? 'disabled' : '' }}>
                                                <!-- Check if school belongs to a group -->
                                                <label class="form-check-label" for="school_{{ $school->id }}">
                                                    {{ $school->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Select Head School</label>
                                    <div class="select">
                                        <select name="head_school" class="" id="headSchoolSelect">
                                            <option value="" selected>Select Head School</option>
                                            <!-- Options will be dynamically added here using JavaScript -->
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 single-input-modal d-flex flex-column">
                                    <label>Email for Head School <span class="must">*</span></label>
                                    <input id="createInput" type="email" name="email"
                                        class="input-text single-input-text" autofocus required
                                        onkeyup="replaceFunction(this.value)" placeholder="Type email">
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- ===================================================================
                        EDIT SCHOOL GROUP MODAL
        =================================================================== --}}
        <div class="modal fade" id="editSchoolGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit School Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            action="{{ route('admin.school-groups.update', ['school_group' => '__dynamic_id']) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12 col-xs-12">
                                <div class="p-2 label-input">
                                    <label>Name<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" name="name" class="editinput-text single-input-text"
                                            id="dynamic_name" autofocus required onkeyup="replaceFunctionTwo(this.value)">

                                    </div>
                                </div>

                                <!-- Schools as checkboxes -->
                                <div class="p-2 label-input">
                                    <label>Schools</label>
                                    <div class="single-input-modal">
                                        {{-- @foreach ($schools as $school)
                                            <div class="form-check">
                                                <input class="form-check-input school-checkbox" type="checkbox"
                                                    name="schools[]" id="school_{{ $school->id }}"
                                                    value="{{ $school->id }}" data-group="{{ $school->group_id }}"
                                                    {{ $school->group ? 'disabled' : '' }}>
                                                <!-- Check if school belongs to a group -->
                                                <label class="form-check-label" for="school_{{ $school->id }}">
                                                    {{ $school->name }}
                                                </label>
                                            </div>
                                        @endforeach --}}
                                        @foreach ($schools as $school)
                                            <div class="form-check">
                                                <input class="form-check-input school-checkbox" type="checkbox"
                                                    name="schools[]" id="school_{{ $school->id }}"
                                                    value="{{ $school->id }}" data-group="{{ $school->group_id }}"
                                                    {{ $school->group ? 'disabled' : '' }}>
                                                <!-- Check if school belongs to a group -->
                                                <label class="form-check-label" for="school_{{ $school->id }}">
                                                    {{ $school->name }}
                                                </label>
                                            </div>
                                            @php
                                                // Store school name in a JavaScript variable for later use
                                                echo '<script>
                                                    var school_ ' . $school->id . '
                                                    _name = "' . $school->name . '";
                                                </script>';
                                            @endphp
                                        @endforeach

                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Select Head School</label>
                                    <div class="single-input-modal">
                                        <select name="head_school" class="form-select" id="editHeadSchoolSelect">
                                            <option value="" selected>Select Head School</option>
                                            <!-- Options will be populated dynamically using JavaScript -->
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 single-input-modal d-flex flex-column">
                                    <label>Email for Head School <span class="must">*</span></label>
                                    <input id="editEmailInput" type="email" name="email"
                                        class="input-text single-input-text" autofocus required
                                        onkeyup="replaceFunction(this.value)" placeholder="Type email">
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- ===================================================================
                        SCHOOL LIST  MODAL
        =================================================================== --}}
        <div class="modal fade" id="list_schools" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">List of Schools</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="school-list-container">
                            <h6>Schools</h6>
                            <!-- Iterate over schools and generate checkboxes -->
                            @foreach ($schools as $school)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="schools[]"
                                        id="school_{{ $school->id }}" value="{{ $school->id }}">
                                    <label class="form-check-label" for="school_{{ $school->id }}">
                                        {{ $school->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <form id="assignHeadSchoolForm" method="POST">
                            {{-- action="{{ route('admin.schoolgroups.assignHeadSchool') }}" --}}
                            @csrf
                            <div class="p-2 label-input">
                                <label>Select Head School</label>
                                <div class="single-input-modal">
                                    <select name="head_school" class="form-select" id="headSchoolSelect">
                                        <option value="" selected>Select Head School</option>
                                        <!-- The options will be dynamically added here using JavaScript -->
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="border-top col-md-12 d-flex justify-content-end p-2">
                                <button type="submit" class="btn btn-success mt-2" id="assignHeadSchoolBtn">Assign Head
                                    School</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#school-groups-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.school-groups.get') }}',
                type: 'post'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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

        document.addEventListener('DOMContentLoaded', function() {
            // Function to update the head school select options based on selected checkboxes
            function updateHeadSchoolOptions() {
                var selectedSchools = document.querySelectorAll('#schoolGroupsForm .school-checkbox:checked');
                var headSchoolSelect = document.getElementById('headSchoolSelect');
                headSchoolSelect.innerHTML = ''; // Clear existing options
                selectedSchools.forEach(function(school) {
                    var option = document.createElement('option');
                    option.value = school.value;
                    option.text = school.nextElementSibling.textContent;
                    headSchoolSelect.appendChild(option);
                });
            }

            // Add event listener to checkboxes to update the head school options
            var checkboxes = document.querySelectorAll('#schoolGroupsForm .school-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateHeadSchoolOptions);
            });
        });


        //edit function
        // $(document).on('click', '.edit-schoolgroup', function() {

        //     // Get the data attributes
        //     var id = $(this).data('id');
        //     var name = $(this).data('name');
        //     var schools = $(this).data('schools');
        //     var headSchoolId = $(this).data('head-school');

        //     console.log(id);
        //     console.log(name);
        //     console.log(schools);
        //     console.log(headSchoolId);

        //     // Set values in the modal form
        //     $('#dynamic_id').val(id);
        //     $('#dynamic_name').val(name);

        //     // Disable checkboxes that belong to other school groups
        //     $('.school-checkbox').each(function() {
        //         var group = $(this).data('group');
        //         if (group != id) {
        //             $(this).prop('disabled', true);
        //         } else {
        //             // If the checkbox belongs to the current group, enable it
        //             $(this).prop('disabled', false);
        //         }
        //     });


        //     // Pre-select checkboxes for associated schools
        //     if (schools) {
        //         schools.forEach(function(schoolId) {
        //             $('input[type="checkbox"][value="' + schoolId + '"]').prop('checked', true);
        //         });
        //     }

        //     // Show the modal
        //     $('#editSchoolGroup').modal('show');

        //     // Prevent the default anchor behavior
        //     return false;
        // });

        // Edit function
        // $(document).on('click', '.edit-schoolgroup', function() {

        //     // Get the data attributes
        //     var id = $(this).data('id');
        //     var name = $(this).data('name');
        //     var schools = $(this).data('schools');
        //     var headSchoolId = $(this).data('head-school');
        //     var headSchoolName = $(this).data('head-school-name');

        //     console.log(schools)
        //     console.log(headSchoolName)

        //     // Set values in the modal form
        //     $('#dynamic_id').val(id);
        //     $('#dynamic_name').val(name);

        //     // Disable checkboxes that belong to other school groups
        //     $('.school-checkbox').each(function() {
        //         var group = $(this).data('group');
        //         if (group != id) {
        //             $(this).prop('disabled', true);
        //         } else {
        //             // If the checkbox belongs to the current group, enable it
        //             $(this).prop('disabled', false);
        //         }
        //     });

        //     // Populate the head school dropdown
        //     var headSchoolOption = $('<option value="' + headSchoolId + '">' + headSchoolName + '</option>');
        //     $('#editHeadSchoolSelect').empty().append(headSchoolOption);


        //     // Show the modal
        //     $('#editSchoolGroup').modal('show');

        //     // Prevent the default anchor behavior
        //     return false;
        // });

        // Edit function
        $(document).on('click', '.edit-schoolgroup', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var name = $(this).data('name');
            var schools = $(this).data('schools');
            var headSchoolId = $(this).data('head-school');
            var headSchoolName = $(this).data('head-school-name');

            console.log(schools);
            console.log(headSchoolName);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);

            // Disable checkboxes that belong to other school groups
            $('.school-checkbox').each(function() {
                var group = $(this).data('group');
                if (group != id) {
                    $(this).prop('disabled', true);
                } else {
                    // If the checkbox belongs to the current group, enable it
                    $(this).prop('disabled', false);
                }
            });

            // Check checkboxes for associated schools
            $('input[type="checkbox"]').prop('checked', false); // Uncheck all checkboxes first
            if (schools) {
                schools.forEach(function(schoolId) {
                    $('input[type="checkbox"][value="' + schoolId + '"]').prop('checked', true);
                });
            }

            // Populate the head school dropdown
            // var headSchoolOption = $('<option value="' + headSchoolId + '">' + headSchoolName + '</option>');
            // $('#editHeadSchoolSelect').empty().append(headSchoolOption);

            // Populate the head school dropdown
            var headSchoolSelect = $('#editHeadSchoolSelect');
            headSchoolSelect.empty(); // Clear existing options
            if (headSchoolId && headSchoolName) {
                var headSchoolOption = $('<option value="' + headSchoolId + '">' + headSchoolName + '</option>');
                headSchoolSelect.append(headSchoolOption);
            }

            if (schools) {
                var addedSchools = new Set(); // Initialize a set to keep track of added schools
                schools.forEach(function(schoolId) {
                    if (!addedSchools.has(schoolId) && schoolId !=
                        headSchoolId
                    ) { // Check if the school is not already added and is not the head school
                        addedSchools.add(schoolId); // Add the school to the set to mark it as added
                        var schoolName = window['school_' + schoolId +
                            '_name']; // Fetch school name from JavaScript variable
                        console.log(schoolName);
                        var option = $('<option value="' + schoolId + '">' + schoolName + '</option>');
                        headSchoolSelect.append(option);
                    }
                });
            }




            // Show the modal
            $('#editSchoolGroup').modal('show');
            // Prevent the default anchor behavior
            return false;
        });



        $(document).ready(function() {
            $(document).on('click', '.open-schools-modal', function() {
                var groupId = $(this).data('id');

                // Perform any additional actions you need before opening the modal
                // $.ajax({
                //     url: '/admin/school-groups/' + groupId + '/schools', // Fix the URL
                //     type: 'GET',
                //     dataType: 'json', // Expecting JSON response
                //     success: function(data) {
                //         // Update modal content dynamically
                //         $('#school-list-container').empty();
                //         $.each(data.schools, function(index, school) {
                //             var schoolHtml = '<p>' + school.name + (school
                //                 .head_school == 1 ?
                //                 ' <span class="must">(head)</span>' : '') + '</p>';

                //             $('#school-list-container').append(schoolHtml);
                //         });

                //         // Populate the dropdown with schools
                //         $('#headSchoolSelect').empty();
                //         $('#headSchoolSelect').append(
                //             '<option value="" selected>Select Head School</option>');
                //         $.each(data.schools, function(index, school) {
                //             $('#headSchoolSelect').append('<option value="' + school
                //                 .id + '">' + school.name + '</option>');
                //         });
                //         $('#list_schools').modal('show');
                //     },
                //     error: function(error) {
                //         console.log(error);
                //     }
                // });

                // Open the modal
                $('#list_schools').modal('show');
            });
        });
    </script>
@endsection
@endsection
