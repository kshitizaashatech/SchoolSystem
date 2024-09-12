@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.topics.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="topics-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Subject Group</th>
                                                <th>Subject</th>
                                                <th>Lesson</th>
                                                <th>Topic name</th>
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

        <div class="modal fade" id="createTopic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Topic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="topicForm" action="{{ route('admin.topics.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label for="class_id">Class</label>
                                    <div class="single-input-modal">

                                        <select name="class_id" id="dynamic_class_id" class="input-text single-input-text">
                                            <option value="" disabled selected>Select Class</option>
                                            @foreach ($classess as $classs)
                                                <option value="{{ $classs['id'] }}" id="class_{{ $classs['id'] }}">
                                                    {{ $classs['class'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label for="section_id"> Section:</label>
                                    <div class="single-input-modal">
                                        <select name="sections[]" id="dynamic_section_id"
                                            class="input-text single-input-text">
                                            <option disabled>Select Section</option>
                                        </select>
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

                                <div class="p-2 label-input">
                                    <label for="lesson_id"> Lesson:</label>
                                    <div class="single-input-modal">
                                        <select name="lesson_id" id="dynamic_lesson_id"
                                            class="input-text single-input-text">
                                            <option disabled>Select Lesson</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <button id="addTopic">Add Topic</button>
                                <div id="topicContainer">
                                    <div class="p-2 label-input">
                                        <label>Topic Name<span class="must">*</span></label>
                                        <div class="single-input-modal">
                                            <input type="text" value="" name="topic_name[]"
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

        $('#topics-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.topics.get') }}',
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
                    data: 'topics',
                    name: 'topics'
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

        $(document).on('click', '.createTopic', function() {
            // $('select[name="class_id"]').empty();
            // $('#dynamic_subject_group_id').empty();
            $('select[name="subject_group_id"]').empty();
            $('select[name="subject_id"]').empty();
            $('select[name="lesson_id"]').empty();
            $('#topicContainer').empty();
            $('#createTopic').modal('show');
        });

        // Attach change event handler to the class dropdown
        $('select[name="class_id"]').change(function() {
            // Get the selected class ID
            var classId = $(this).val();
            // Fetch sections based on the selected class ID
            fetchSections(classId, function() {
                $('select[name="sections[]"').change(function() {
                    var sectionsSelected = [];

                    // Iterate through checked checkboxes and collect section selected
                    sectionsSelected.push($(this).val());

                    console.log("selected sections: " + sectionsSelected);
                    classSectionData = {
                        class_id: classId,
                        sections: sectionsSelected
                    }
                    fetchSubjectGroup(classSectionData, function() {
                        $('select[name="subject_group_id"]').change(function() {
                            var subjectGroupId = $(this).val();
                            console.log("Subject Group:" + subjectGroupId);
                            fetchSubjects(subjectGroupId, function() {
                                $('select[name="subject_id"]').change(
                                    function() {
                                        var subjectId = $(this).val();
                                        console.log("Subject Id: " +
                                            subjectId);
                                        classSectionSubjectgroupSubjectData
                                            = {
                                                class_id: classId,
                                                sections: sectionsSelected,
                                                subject_group_id: subjectGroupId,
                                                subject_id: subjectId
                                            }
                                        fetchLessons(
                                            classSectionSubjectgroupSubjectData,
                                            function() {

                                            });

                                    });
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
                        '<option disabled selected>Select Subject</option>');

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
                    $('select[name="sections[]"]').empty();

                    // Add the default option
                    $('select[name="sections[]"]').append(
                        '<option disabled selected>Select Section</option>');

                    // Add new options based on the fetched sections
                    $.each(data, function(key, value) {
                        $('select[name="sections[]"]').append('<option value="' +
                            key + '">' + value + '</option>');
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
            console.log(classSectionData);
            $.ajax({
                url: '{{ url('admin/get-subject-group-by-class-and-section') }}',
                type: 'GET',
                data: classSectionData,
                success: function(data) {
                    // Clear existing checkboxes
                    $('#dynamic_subject_group_id').empty();
                    $('select[name="subject_group_id"]').empty();
                    $('select[name="subject_id"]').empty();
                    $('select[name="lesson_id"]').empty();

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
            console.log(classSectionSubjectgroupSubjectData);
            $.ajax({
                url: '{{ url('admin/get-lessons-by-class-section-subjectgroup-and-subject') }}',
                type: 'GET',
                data: classSectionSubjectgroupSubjectData,
                success: function(data) {
                    // Clear existing options
                    $('select[name="lesson_id"]').empty();

                    // Add the default option
                    $('select[name="lesson_id"]').append(
                        '<option disabled selected>Select Lesson</option>');

                    // Add new options based on the fetched sections
                    $.each(data, function(index, lesson) {
                        $('select[name="lesson_id"]').append('<option value="' +
                            lesson.id + '">' + lesson.name + '</option>');
                    });

                    // Call the callback function after the checkboxes are added
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }

        // Define a function for lesson selection through class, section, subjectgroup, subject
        function fetchTopics(classSectionSubjectgroupSubjectLessonData, callback) {
            // console.log(classSectionData);
            $.ajax({
                url: '{{ url('admin/get-topics--by-class-section-subjectgroup-subject-and-lessons') }}',
                type: 'GET',
                data: classSectionSubjectgroupSubjectLessonData,
                success: function(data) {
                    // Clear existing checkboxes
                    $('#topicContainer').empty();

                    // Add checkboxes based on the fetched data
                    var selectContainer = $('#dynamic_subject_group_id');

                    if (data.length > 0) {
                        data.forEach(function(value) {
                            var newTopic = `<div class="p-2 label-input">
            <label>Topic Name<span class="must">*</span></label>
            <div class="single-input-modal">
                <input type="text" value="${value.topic_name}" name="topic_name[]" class="input-text single-input-text" required>
                <button class="removeTopic">Remove Topic</button>
            </div>
        </div>`;
                            $("#topicContainer").append(newTopic);
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

        $(document).on('click', '.edit-topic', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var class_id = $(this).data('class_id');
            var section_id = $(this).data('section_id');
            var subject_group_id = $(this).data('subject_group_id');
            var subject_id = $(this).data('subject_id');
            var lesson_id = $(this).data('lesson_id');

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
                            $('#dynamic_lesson_id option[value="' +
                                lesson_id + '"]').prop('selected',
                                true);
                            classSectionSubjectgroupSubjectLessonData = {
                                class_id: class_id,
                                sections: sectionsSelected,
                                subject_group_id: subject_group_id,
                                subject_id: subject_id,
                                lesson_id: lesson_id
                            }
                            fetchTopics(classSectionSubjectgroupSubjectLessonData,
                                function() {

                                });
                        });

                    });
                });
            });


            // Set values in the modal form

            $('#topicForm').attr('action', '{{ route('admin.topics.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createTopic').modal('show');
            return false;
        });

        $(document).ready(function() {
            // Add Lesson Button
            $("#addTopic").on("click", function() {
                var newTopic = `<div class="p-2 label-input">
                <label>Topic Name<span class="must">*</span></label>
                <div class="single-input-modal">
                    <input type="text" value="" name="topic_name[]" class="input-text single-input-text" required>
                    <button class="removeTopic">Remove Topic</button>
                </div>
            </div>`;
                $("#topicContainer").append(newTopic);
            });

            // Remove Lesson Button
            $("#topicContainer").on("click", ".removeTopic", function() {
                $(this).closest(".label-input").remove();
            });
        });
    </script>
@endsection
@endsection
