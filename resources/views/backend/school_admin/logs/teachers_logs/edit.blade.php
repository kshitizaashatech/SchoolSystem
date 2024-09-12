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
            @include('backend.school_admin.logs.teachers_logs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="container">
                        <div class="row">
                            <form id="regForm" action="{{ route('admin.teacher-logs.update', $teacherlogs->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="teacher_log_id" value="{{ $teacherlogs->teacher_log_id }}">
                                <input type="hidden" name="school_id" value="{{ $teacherlogs->school_id }}">
                                <input type="hidden" name="academic_session_id"
                                    value="{{ $teacherlogs->academic_session_id }}">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <label for="class_id"> Class:</label>
                                            <div class="form-group select">
                                                <select name="class_id" id="dynamic_class_id"
                                                    class="input-text single-input-text">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $classs)
                                                        <option value="{{ $classs['id'] }}" id="class_{{ $classs['id'] }}">
                                                            {{ $classs['class'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('class_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <label for="section_id"> Section:</label>
                                            <div class="select">
                                                <select name="sections[]" id="dynamic_section_id">
                                                    <option disabled>Select Section</option>
                                                </select>
                                            </div>
                                            @error('sections')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <label for="subject_group_id"> Subject Group:</label>
                                            <div class="form-group select">
                                                <select name="subject_group_id" id="dynamic_subject_group_id"
                                                    class="input-text single-input-text">
                                                    <option disabled>Select Subject Group</option>
                                                </select>
                                            </div>
                                            @error('subject_group_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <label for="subject_id"> Subject:</label>
                                            <div class="form-group select">
                                                <select name="subject_id" id="dynamic_subject_id"
                                                    class="input-text single-input-text">
                                                    <option disabled>Select Subject</option>
                                                </select>
                                            </div>
                                            @error('subject_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <label for="subject_id"> Lesson:</label>
                                            <div class="form-group select">
                                                <select name="lesson_id" id="dynamic_lesson_id"
                                                    class="input-text single-input-text">
                                                    <option disabled>Select Lesson</option>
                                                </select>
                                            </div>
                                            @error('lesson_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <label for="topic_id"> Topic:</label>
                                            <div class="form-group select">
                                                <select name="topic_id" id="dynamic_topic_id"
                                                    class="input-text single-input-text">
                                                    <option disabled>Select Topic</option>
                                                </select>
                                            </div>
                                            @error('topic_id')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <label for="datetimepicker">Lock Book Date:</label>
                                            <div class="form-group">
                                                <div class="input-group date" id="datetimepicker"
                                                    data-target-input="nearest">
                                                    <input id="nepali-datepicker"
                                                        value="{{ old('log_book_date', $teacherlogs->log_book_date) }}"
                                                        name="log_book_date" type="text"
                                                        class="form-control datetimepicker-input" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <label for="textArea">Classroom Activities/ Classwork</label>
                                            <div class="form-group">
                                                <textarea style="max-width: 30%;" class="form-control note-editable" name="classwork" id="summernote"
                                                    placeholder="Add Description">{{ old('classwork', $teacherlogs->classwork ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <label for="textArea">Home Work</label>
                                            <div class="form-group">
                                                <textarea style="max-width: 30%;" class="form-control note-editable" name="homework" id="summernote1"
                                                    placeholder="Add Description">{{ old('homework', $teacherlogs->homework ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <label for="fileInput">Attach Document:</label>
                                            <img src="{{ $teacherlogs->file ? asset('storage/teacher_log/' . $teacherlogs->file) : '' }}"
                                                id="image" style="width: 20%;">
                                            <div class="form-group">
                                                <input type="file" name="file" class="form-control-file"
                                                    id="fileInput">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="border-top pt-3 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('backend.includes.nepalidate')
    <script>
        $(document).ready(function() {

            var id = "{{ $teacherlogs->teacher_log_id }}"
            var class_id = "{{ $teacherlogs->class_id }}"
            var section_id = "{{ $teacherlogs->section_id }}"
            var subject_group_id = "{{ $teacherlogs->subject_group_id }}"
            var subject_id = "{{ $teacherlogs->subject_id }}"
            var lesson_id = "{{ $teacherlogs->lesson_id }}"
            var topic_id = "{{ $teacherlogs->topic_id }}"
            console.log(topic_id);
            // Attach change event handler to the class dropdown

            $('select[name="class_id"] option').prop('selected', false); // Deselect all options
            $('#dynamic_class_id option[value="' + class_id + '"]').prop('selected',
                true); // Select the option with the matching value

            fetchSections(class_id, function() {
                $('#dynamic_section_id option[value="' +
                    section_id + '"]').prop('selected', true);
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
                            console.log("lesson_id" + lesson_id);
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
                                    console.log(topic_id);
                                    $('#dynamic_topic_id option[value="' +
                                        topic_id + '"]').prop('selected',
                                        true);
                                });
                        });

                    });
                });
            });

            $('select[name="class_id"]').change(function() {
                // Get the selected class ID
                var classId = $(this).val();
                // Fetch sections based on the selected class ID
                fetchSections(classId, function() {
                    $('select[name="sections[]"').change(function() {

                        var sectionsSelected = [];
                        sectionsSelected.push($(this).val());
                        classSectionData = {
                            class_id: classId,
                            sections: sectionsSelected
                        }
                        fetchSubjectGroup(classSectionData, function() {
                            $('select[name="subject_group_id"]').change(function() {

                                var subjectGroupId = $(this).val();
                                fetchSubjects(subjectGroupId, function() {
                                    $('select[name="subject_id"]')
                                        .change(
                                            function() {
                                                var subjectId = $(
                                                    this).val();
                                                classSectionSubjectgroupSubjectData
                                                    = {
                                                        class_id: classId,
                                                        sections: sectionsSelected,
                                                        subject_group_id: subjectGroupId,
                                                        subject_id: subjectId
                                                    }
                                                console.dir(
                                                    classSectionSubjectgroupSubjectData
                                                );
                                                fetchLessons(
                                                    classSectionSubjectgroupSubjectData,
                                                    function() {

                                                        $('select[name="lesson_id"]')
                                                            .change(
                                                                function() {
                                                                    var lessonId =
                                                                        $(
                                                                            this
                                                                        )
                                                                        .val();
                                                                    classSectionSubjectgroupSubjectLessonData
                                                                        = {
                                                                            class_id: classId,
                                                                            sections: sectionsSelected,
                                                                            subject_group_id: subjectGroupId,
                                                                            subject_id: subjectId,
                                                                            lesson_id: lessonId
                                                                        }
                                                                    fetchTopics
                                                                        (classSectionSubjectgroupSubjectLessonData,
                                                                            function() {

                                                                            }
                                                                        );

                                                                }
                                                            );
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
                        $('select[name="lesson_id"]').empty();
                        $('select[name="topic_id"]').empty();

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
                        // Clear existing options
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
                // console.log(classSectionData);
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
                        $('select[name="topic_id"]').empty();

                        // Add checkboxes based on the fetched data
                        var selectContainer = $('#dynamic_subject_group_id');

                        if (data.length > 0) {
                            selectContainer.append(
                                '<option disabled selected value>Choose Subject Group</option>');
                            $.each(data, function(key, value) {
                                selectContainer.append('<option value="' + value.id + '">' +
                                    value
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
                $.ajax({
                    url: '{{ url('admin/get-lessons-by-class-section-subjectgroup-and-subject') }}',
                    type: 'GET',
                    data: classSectionSubjectgroupSubjectData,
                    success: function(data) {
                        // Clear existing options
                        $('select[name="lesson_id"]').empty();
                        $('select[name="topic_id"]').empty();

                        // Add the default option
                        $('select[name="lesson_id"]').append(
                            '<option disabled selected>Select Lesson</option>');

                        // Add new options based on the fetched sections
                        $.each(data, function(index, lesson) {
                            console.log("lesson id: " + lesson.id);
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
                        $('select[name="topic_id"]').empty();

                        // Add the default option
                        $('select[name="topic_id"]').append(
                            '<option disabled selected>Select Lesson</option>');

                        // Add new options based on the fetched sections
                        $.each(data, function(index, topic) {
                            console.log(topic.id);
                            $('select[name="topic_id"]').append('<option value="' +
                                topic.id + '">' + topic.topic_name + '</option>');
                        });

                        // Call the callback function after the checkboxes are added
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                });
            }
        });
    </script>
@endsection
