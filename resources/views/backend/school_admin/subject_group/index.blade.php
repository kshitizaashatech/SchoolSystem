@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.subject_group.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">

                                    <table
                                        class="table table-striped table-bordered table-hover example dataTable no-footer">
                                        <thead>
                                            <tr role="row">
                                                <th>Subject Group Name</th>
                                                <th>Class Section</th>
                                                <th>Subjects</th>
                                                <th>Status</th>
                                                <th class="text-right noExport">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results as $subjectGroups)
                                                <tr>
                                                    <td>{{ $subjectGroups['subject_group_name'] }}</td>
                                                    <td>
                                                        <ul class="liststyle1">
                                                            @foreach ($subjectGroups['classes'] as $classes)
                                                                @foreach ($subjectGroups['sections'] as $sections)
                                                                    <li>
                                                                        <div class="row">
                                                                            <div class="col-md-6">

                                                                                {{ $classes->class }}[{{ $sections->section_name }}]

                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul class="liststyle1">
                                                            @foreach ($subjectGroups['subjects'] as $subjects)
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-md-6">

                                                                            {{ $subjects->subject }}

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td><span
                                                            class="btn-sm {{ $subjectGroups['is_active'] == 1 ? 'btn-success' : 'btn-danger' }}">
                                                            {{ $subjectGroups['is_active'] == 1 ? 'Active' : 'Inactive' }}
                                                        </span></td>
                                                    <td class="text-right">
                                                        @include(
                                                            'backend.school_admin.subject_group.partials.controller_action',
                                                            ['subjectGroups' => $subjectGroups]
                                                        )
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Subject Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="subjectForm" action="{{ route('admin.subject-groups.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">

                                <div class="p-2 label-input">
                                    <label>Subject Group Name<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('subject_group_name') }}"
                                            name="subject_group_name" class="input-text single-input-text" id="dynamic_name"
                                            autofocus required>
                                    </div>
                                    <div class="label-input mt-2">
                                        <label for="class_id">Class<span class="must"> *</span></label>
                                        <div class="select">

                                            <select name="class_id" id="dynamic_class_id">
                                                <option value="">Select Class</option>
                                                @foreach ($classess as $classs)
                                                    <option value="{{ $classs['id'] }}">{{ $classs['class'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex justify-content-between label-input">
                                            <label class="d-flex align-items-center mt-2" for="section_id">Section<span
                                                    class="must"> *</span></label>
                                            <label class="l-checkbox select-all-checkbox" style="display: none;">
                                                <span>Select All</span>
                                                <input type="checkbox" id="select_all_sections">
                                            </label>
                                        </div>
                                        <div class="hr-line-dashed mt-2"></div>
                                        <div class="checkbox-container">
                                            <div class="section_selection">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 label-input">
                                        <label>Available Subjects<span class="must"> *</span></label>
                                        <div class="checkbox-container">
                                            @foreach ($subjectgroup as $subject)
                                                <label class="l-checkbox" for="subject_{{ $subject->id }}">
                                                    <span>{{ $subject->subject }}</span>
                                                    <input class="" type="checkbox" name="subject_group[]"
                                                        id="subject_{{ $subject->id }}" value="{{ $subject->id }}"
                                                        {{ isset($selectedSubjects) && in_array($subject->id, $selectedSubjects) ? 'checked' : '' }}>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 col-xs-12 mt-4">
                                        <label>Status<span class="must"> *</span></label>
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

                                    <div class="border-top col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>

                                    </div>
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
        $('#subject-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.subject-groups.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'subject_group_name',
                    name: 'subject_group_name'
                },
                // {
                //     data: 'subject_id',
                //     name: 'subject_id'
                // },
                {
                    data: 'subjects',
                    name: 'subjects'
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

        $(document).on('click', '.createSubject', function() {
            // $('select[name="class_id"]').empty();
            $('#dynamic_name').val('');
            // $('select[name="class_id"]').empty();
            $('.section_selection').empty();
            // $('.checkbox-container').empty();
            // Select all checkboxes by their name attribute
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="subject_group[]"]');

            // Loop through each checkbox and remove the checked attribute
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            $('#createSubject').modal('show');
        });

        // Attach change event handler to the class dropdown
        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();
            // Fetch sections based on the selected class ID
            fetchSections(classId);
        });

        // Define a function for the AJAX call
        function fetchSections(classId, callback) {
            $.ajax({
                url: '{{ url('admin/get-section-by-class') }}/' + classId,
                type: 'GET',
                success: function(data) {
                    // Clear existing checkboxes
                    $('.section_selection').empty();

                    // Add checkboxes based on the fetched data
                    var checkboxContainer = $('.section_selection');

                    // By default, use radio buttons
                    var inputType = 'radio';

                    $.each(data, function(key, value) {
                        var checkbox = $('<label class="l-checkbox" for="section_' + key + '">' +
                            '<span>' + value + '</span>' +
                            '<input class="section-checkbox" type="' + inputType +
                            '" name="sections[]" id="section_' +
                            key +
                            '" value="' + key + '">' +
                            '</label>');
                        checkboxContainer.append(checkbox);
                    });

                    // Show the 'Select All' checkbox
                    $('.select-all-checkbox').show();

                    // Attach change event handler to 'Select All' checkbox
                    $('#select_all_sections').change(function() {
                        var isChecked = $(this).prop('checked');
                        // Change the type of input elements when "Select All" checkbox is checked
                        inputType = isChecked ? 'checkbox' : 'radio';
                        $('.section-checkbox').prop('type', inputType);
                        // Check/uncheck all section checkboxes when "Select All" checkbox is checked/unchecked
                        $('.section-checkbox').prop('checked', isChecked);
                    });

                    // Attach change event handler to individual section checkboxes
                    $('.section-checkbox').change(function() {
                        if ($(this).prop('checked')) {
                            $('#select_all_sections').prop('checked', false);
                        }
                    });

                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }

        $(document).on('click', '.edit-subject', function() {
            var id = $(this).data('id');
            var subjectGroupName = $(this).data('subject_group_name');
            var classId = $(this).data('class_id');
            var is_active = $(this).data('is_active');
            var selectedSections = $(this).data('sections');
            // Fetch sections and check checkboxes after they are added
            fetchSections(classId, function() {
                $('input[name="sections[]"]').prop('checked', false);
                selectedSections.forEach(function(section) {
                    $('#section_' + section.id).prop('checked', true);
                });
            });

            // Fetch related subjects separately
            $.ajax({
                url: 'get-subjects-by-subject-group/' + id,
                method: 'GET',
                success: function(subjects) {
                    // subjects will contain an array of related subjects

                    // Extract subject ids from the fetched subjects
                    var selectedSubjects = subjects.map(function(subject) {
                        return subject.id;
                    });

                    // Set the values in the modal form
                    $('#dynamic_id').val(id);
                    $('#dynamic_name').val(subjectGroupName);
                    $('#dynamic_class_id').val(classId);

                    // Check the checkboxes for selected subjects
                    $('input[name="subject_group[]"]').prop('checked', false);
                    selectedSubjects.forEach(function(subjectId) {
                        $('#subject_' + subjectId).prop('checked', true);
                    });

                    $('input[name="is_active"]').prop('checked', false);
                    $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

                    $('#subjectForm').attr('action', '{{ route('admin.subject-groups.update', '') }}' +
                        '/' + id);
                    $('#methodField').val('PUT');

                    // Show the modal after setting the values
                    $('#createSubject').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching subjects:', error);
                }
            });

            return false;
        });
    </script>
@endsection
@endsection
