@extends('backend.layouts.master')


@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">

            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form id="updateForm" method="POST"
                            action="{{ route('admin.primaryexam-routines.update', $routine->id) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="examination_id" value="{{ $routine->examination_id }}">
                            <input type="hidden" name="subject_group_id" value="{{ $routine->subject_group_id }}">
                            <input type="hidden" name="class_id" value="{{ $routine->class_id }}">
                            <input type="hidden" name="section_id" value="{{ $routine->section_id }}">

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

                            <div class="mt-4">
                                <table class="table table-bordered" id="item_table">
                                    <thead>
                                        <tr>
                                            <th>Subject<small class="req"> *</small></th>
                                            <th>Exam Date<small class="req"> *</small></th>
                                            <th>Exam Start Time<small class="req"> *</small></th>
                                            <th>Duration<small class="req"> *</small></th>
                                            <th>Credit Hours<small class="req"> *</small></th>
                                            <th>Room No.<small class="req"> *</small></th>
                                            <th>Marks (Max..)<small class="req"> *</small></th>
                                            <th>Marks (Min..)<small class="req"> *</small></th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_table_body">
                                        {{-- Dynamically fetched data will be inserted here --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-success" id="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch subjects based on class, section, and subject group IDs on page load
        $(document).ready(function() {
            var classId = $('input[name="class_id"]').val();
            var sectionId = $('input[name="section_id"]').val();
            var subjectGroupId = $('input[name="subject_group_id"]')
                .val(); // Assuming you have a hidden input for subject_group_id in your form
            console.log(`CLASS ID - ${classId}`);
            console.log(`Section ID - ${sectionId}`);
            console.log(`Subject Group ID - ${subjectGroupId}`);
            fetchSubjects(subjectGroupId, classId, sectionId);
        });

        // Define a function to fetch subjects based on subject group ID, class ID, and section ID
        function fetchSubjects(subjectGroupId, classId, sectionId) {
            $.ajax({
                url: '{{ url('admin/get-subjects-by-subject-group') }}',
                type: 'GET',
                data: {
                    subject_group_id: subjectGroupId,
                    class_id: classId,
                    section_id: sectionId
                },
                success: function(data) {

                    var tbody = $('#item_table_body');
                    tbody.empty();

                    // Iterate over fetched subjects
                    $.each(data, function(index, subject) {
                        // Create a new row for each subject
                        console.log(subject);
                        var newRow = $('<tr>');

                        // Append hidden input fields for subject_group_id and subject_id
                        newRow.append(
                            '<input type="hidden" name="subject_group_id[]" value="' +
                            subject.subject_group_id + '">');
                        newRow.append(
                            '<input type="hidden" name="subject_id[]" value="' +
                            subject.subject_id + '">');

                        // Append cells with subject information to the new row
                        newRow.append('<td>' + subject.subject.subject + '</td>');

                        newRow.append(
                            '<td><input required class="form-control" name="exam_date[]" type="text" value="' +
                            subject.exam_date + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="exam_time[]" type="text" value="' +
                            subject.exam_time + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="exam_duration[]" type="text" value="' +
                            subject.exam_duration + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="credit_hour[]" type="text" value="' +
                            subject.credit_hour + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="room_no[]" type="text" value="' +
                            subject.room_no + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="full_marks[]" type="number" value="' +
                            subject.full_marks + '"></td>'
                        );
                        newRow.append(
                            '<td><input required class="form-control" name="pass_marks[]" type="number" value="' +
                            subject.pass_marks + '"></td>'
                        );

                        // Append the new row to the table body
                        tbody.append(newRow);
                    });
                }
            });
        }
    </script>
@endsection
