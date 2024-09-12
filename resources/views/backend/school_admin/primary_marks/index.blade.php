@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.primary_marks.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">

                                    <table id="primarymarks-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Subject Group</th>
                                                <th>Subject</th>
                                                <th>Lesson Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                            @foreach ($lessons as $classId => $class)
                                                @foreach ($class as $sectionId => $section)
                                                    <tr>
                                                        <td>{{ $section['id'] }}</td>
                                                        <td>{{ $section['class_name'] }}</td>
                                                        <td>{{ $section['section_name'] }}</td>
                                                        <td>{{ $section['subject_group_name'] }}</td>
                                                        <td>{{ $section['subject_name'] }}</td>
                                                        <td>

                                                            @foreach ($section['subject'] as $subjectId => $subject)
                                                                @foreach ($subject['lessons'] as $lesson)
                                                                    <p>{{ $lesson['name'] }}</p>
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody> --}}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createPrimaryMarks" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Lesson/Marks</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="lessonForm" action="{{ route('admin.primary-lessonmarks.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label for="class_id">Class</label>
                                    <div class="single-input-modal">

                                        <select name="class_id" id="dynamic_class_id" class="input-text single-input-text">
                                            <option value="">Select Class</option>
                                            @foreach ($classess as $classs)
                                                <option value="{{ $classs['id'] }}" id="class_{{ $classs['id'] }}">
                                                    {{ $classs['class'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label for="section_id">Section</label>
                                    <div class="checkbox-container">
                                        <div class="section_selection">

                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label for="subject_group_id">Subject Group</label>
                                    <div class="single-input-modal">

                                        <select name="subject_group_id" id="dynamic_subject_group_id"
                                            class="input-text single-input-text">
                                            <option value="">Select Subject Group</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label for="subject_id"> Subject:</label>
                                    <div class="single-input-modal">
                                        <select name="subject_id" id="dynamic_subject_id"
                                            class="input-text single-input-text">
                                            <option disabled>Select Subject</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2">

                                    <button id="addLesson">Add Lesson</button>
                                </div>
                                <div id="lessonContainer" class="d-flex flex-wrap">
                                    <div class="p-2 label-input">
                                        <label>Lesson Name<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <input type="text" value="" name="lessons[]"
                                                class="input-text single-input-text" required>
                                        </div>
                                    </div>
                                    <div class="p-2 label-input" style="flex-grow: 0; flex-basis: 20%;">
                                        <label>Count<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <input type="text" value="" name="marks[]"
                                                class="input-text single-input-text" required>
                                        </div>
                                    </div>
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
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#primarymarks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.primary-lessonmarks.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'class',
                    name: 'class'
                },
                {
                    data: 'section',
                    name: 'section'
                },
                {
                    data: 'subject_group',
                    name: 'subject_group'
                },
                {
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'lessons',
                    name: 'lessons'
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

        // Attach change event handler to the class dropdown
        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();
            // Fetch sections based on the selected class ID
            fetchSections(classId, function() {
                //onclicking the checkbox fetch subject-groups associated to class and section
                $('.section-checkbox').click(function() {
                    var sectionsSelected = [];

                    // Iterate through checked checkboxes and collect section selected
                    $('.section-checkbox:checked').each(function() {
                        sectionsSelected.push($(this).val());
                    });
                    classSectionData = {
                        class_id: classId,
                        sections: sectionsSelected
                    }
                    fetchSubjectGroup(classSectionData, function() {
                        $('select[name="subject_group_id"]').change(function() {
                            var subjectGroupId = $(this).val();
                            fetchSubjects(subjectGroupId, function() {

                            });

                        });
                    });
                });
            });
        });

        // Define a function for subject selection through subjectGroupId
        function fetchSubjects(subjectGroupId, callback) {
            $.ajax({
                url: '{{ url('admin/get-subjects-by-subject-group') }}/' + subjectGroupId,
                type: 'GET',
                success: function(data) {
                    // Clear existing options
                    $('select[name="subject_id"]').empty();

                    // Add the default option
                    $('select[name="subject_id"]').append(
                        '<option disabled>Select Subject</option>');

                    // Add new options based on the fetched sections
                    $.each(data, function(index, subject) {
                        $('select[name="subject_id"]').append('<option value="' +
                            subject.id + '">' + subject.subject + '</option>');
                    });
                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }
        // Define a function for section selection through classID
        function fetchSections(classId, callback) {
            $.ajax({
                url: '{{ url('admin/get-section-by-class') }}/' + classId,
                type: 'GET',
                success: function(data) {
                    // Clear existing checkboxes
                    $('.section_selection').empty();

                    // Add checkboxes based on the fetched data
                    var checkboxContainer = $('.section_selection');

                    $.each(data, function(key, value) {
                        var checkbox = $('<label id="sections_' + key +
                            '" class="l-checkbox" for="section_' + key + '">' +
                            '<span>' + value + '</span>' +
                            '<input class="section-checkbox" type="checkbox" name="sections[]" id="section_' +
                            key +
                            '" value="' + key + '">' +
                            '</label>');
                        checkboxContainer.append(checkbox);
                    });
                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }

        // Define a function for section selection through classID
        function fetchSubjectGroup(classSectionData, callback) {
            // console.log(classSectionData);
            $.ajax({
                url: '{{ url('admin/get-subject-group-by-class-and-section') }}',
                type: 'GET',
                data: classSectionData,
                success: function(data) {
                    // Clear existing checkboxes
                    $('#dynamic_subject_group_id').empty();
                    $('select[name="subject_id"]').empty();

                    // Add checkboxes based on the fetched data
                    var selectContainer = $('#dynamic_subject_group_id');

                    if (data.length > 0) {
                        selectContainer.append(
                            '<option disabled selected value>Choose Subject Group</option>');
                        $.each(data, function(key, value) {
                            selectContainer.append('<option value="' + value.id + '">' + value
                                .subject_group_name + '</option>');
                        });
                    } else {
                        selectContainer.append(
                            '<option value="">No Subject Group found</option>');
                    }
                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }

        // Define a function for lesson selection through class, section, subjectgroup, subject
        function fetchLessons(classSectionSubjectgroupSubjectData, callback) {
            // console.log(classSectionData);
            $.ajax({
                url: '{{ url('admin/get-lessons-by-class-section-subjectgroup-and-subjectprimary') }}',
                type: 'GET',
                data: classSectionSubjectgroupSubjectData,
                success: function(data) {
                    // Clear existing checkboxes
                    $('#lessonContainer').empty();

                    // Add checkboxes based on the fetched data
                    var selectContainer = $('#dynamic_subject_group_id');

                    if (data.length > 0) {
                        data.forEach(function(value) {
                            console.log(value)
                            var newLesson = `<div class="d-flex"><div class="p-2 label-input">
                <label>Lesson Name<span class="must">*</span></label>
                <div class="single-input-modal">
                    <input type="text" value="${value.name}" name="lessons[]" class="input-text single-input-text" required>
                    <button class="removeLesson">Remove Lesson</button>
                </div>
            </div>
            <div class="p-2 label-input" style="flex-grow: 0; flex-basis: 20%;">
                                        <label>Marks<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <input type="text" value="${value.marks}" name="marks[]"
                                                class="input-text single-input-text" required>
                                        </div>
                                    </div></div>`;
                            $("#lessonContainer").append(newLesson);
                        });
                    } else {
                        // Handle the case where data is empty or doesn't exist
                    }

                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }

        $(document).on('click', '.edit-primarymarks', function() {
            // console.log('zxczxc')
            // Get the data attributes
            var id = $(this).data('id');
            var class_id = $(this).data('class_id');
            var section_id = $(this).data('section_id');
            var subject_group_id = $(this).data('subject_group_id');
            var subject_id = $(this).data('subject_id');



            $('select[name="class_id"] option').prop('selected', false); // Deselect all options
            $('#dynamic_class_id option[value="' + class_id + '"]').prop('selected',
                true); // Select the option with the matching value

            fetchSections(class_id, function() {
                var sections = $('#sections_' + section_id);
                // If the element exists, keep it and remove all other dynamic content
                $('[id^="sections_"]').not('#sections_' + section_id).remove();

                // $('input[name="sections[]"]').prop('checked', false);
                $('#section_' + section_id).prop('checked', true);
                var sectionsSelected = [];
                sectionsSelected.push(section_id);
                classSectionData = {
                    class_id: class_id,
                    sections: sectionsSelected
                }
                fetchSubjectGroup(classSectionData, function() {
                    $('#dynamic_subject_group_id option[value="' +
                        subject_group_id + '"]').prop('selected', true);
                    fetchSubjects(subject_group_id, function() {
                        $('#dynamic_subject_id option[value="' +
                            subject_id + '"]').prop('selected',
                            true);
                        classSectionSubjectgroupSubjectData = {
                            class_id: class_id,
                            sections: sectionsSelected,
                            subject_group_id: subject_group_id,
                            subject_id: subject_id
                        }
                        fetchLessons(classSectionSubjectgroupSubjectData, function() {

                        });

                    });
                });
            });


            // Set values in the modal form
            $('#dynamic_id').val(id);

            $('#lessonForm').attr('action', '{{ route('admin.primary-lessonmarks.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createPrimaryMarks').modal('show');
            return false;
        });

        $(document).ready(function() {
            // Add Lesson Button
            $("#addLesson").on("click", function() {
                var newLesson = `<div class="d-flex"><div class="p-2 label-input">
                <label>Lesson Name<span class="must">*</span></label>
                <div class="single-input-modal">
                    <input type="text" value="" name="lessons[]" class="input-text single-input-text" required>
                    <button class="removeLesson">Remove Lesson</button>
                </div>
            </div>
            <div class="p-2 label-input" style="flex-grow: 0; flex-basis: 20%;">
                                        <label>Marks<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <input type="text" value="" name="marks[]"
                                                class="input-text single-input-text" required>
                                        </div>
                                    </div></div>`;
                $("#lessonContainer").append(newLesson);
            });

            // Remove Lesson Button
            $("#lessonContainer").on("click", ".removeLesson", function() {
                $(this).closest(".label-input").remove();
            });
        });
    </script>
@endsection
@endsection
