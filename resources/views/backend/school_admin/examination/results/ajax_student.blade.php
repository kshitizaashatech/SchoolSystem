<div class="col-md-12">
    <input type="hidden" name="exam_schedule_id" value="{{ $examinationScheduleId }}">
    <input type="hidden" name="subject_id" value="{{ $subjectId }}">
    <input type="hidden" id="full_marks" value="{{ $fullMarks }}">
    <div class="table-responsive">
        <h4>{{ $subjectName }}</h4>
        <button id="exportCsv" class="btn btn-sm btn-primary mt-2 ml-2">Export</button>
        <table id="subjectTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Admission No</th>
                    <th>Roll Number</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Gender</th>
                    <th>Attendance</th>
                    <th>Participant Assessment</th>
                    <th>Practical/Project Assessment</th>
                    <th>Theory Assessment</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($examStudents as $index => $examStudent)
                    <tr class="std_adm_{{ $examStudent->studentSession->student->admission_no }}">
                        <input type="hidden" name="student_id[{{ $index }}]" value="{{ $examStudent->studentSession->student->id }}">
                        <input type="hidden" name="exam_student_id[{{ $index }}]" value="{{ $examStudent->id }}">
                        <input type="hidden" name="student_session_id[{{ $index }}]" value="{{ $examStudent->student_session_id }}">
                        <td>{{ $examStudent->studentSession->student->admission_no }}</td>
                        <td>{{ $examStudent->studentSession->student->roll_no }}</td>
                        <td>{{ $examStudent->studentSession->student->user->f_name . ' ' . $examStudent->studentSession->student->user->m_name . ' ' . $examStudent->studentSession->student->user->l_name }}</td>
                        <td>{{ $examStudent->studentSession->student->user->father_name }}</td>
                        <td>{{ $examStudent->studentSession->student->user->gender }}</td>
                        <td>
                            <div>
                                <input type="hidden" name="attendance[{{ $index }}]" value="1">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="attendance_chk" name="attendance[{{ $index }}]" value="0" {{ $examStudent->is_active ? '' : 'checked' }}>
                                    Present
                                </label>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="participant_assessment form-control" name="participant_assessment[{{ $index }}]" value="{{ $examStudent->participant_assessment ?? '' }}" step="any" max="4">
                            <div class="error-message text-danger participant-assessment-error" style="display:none;">Max limit is 4</div>
                        </td>
                        <td>
                            <input type="number" class="practical_assessment form-control" name="practical_assessment[{{ $index }}]" value="{{ $examStudent->practical_assessment ?? '' }}" step="any" max="36">
                            <div class="error-message text-danger practical-assessment-error" style="display:none;">Max limit is 36</div>
                        </td>
                        <td>
                            <input type="number" class="theory_assessment form-control" name="theory_assessment[{{ $index }}]" value="{{ $examStudent->theory_assessment ?? '' }}" step="any">
                        </td>
                        <td>
                            <input type="text" class="form-control note" name="notes[]" value="{{ $examStudent->notes ?? '' }}" style="width: 250px;">
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-top col-md-12 d-flex justify-content-end p-2">
        <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
    </div>
</div>
<script>
    $(document).ready(function() {
        var fullMarks = parseFloat($('#full_marks').val());

        // Function to calculate and set the max value for theory assessment
        function updateTheoryAssessmentMax(row) {
            // var maxParticipantAssessment = 4; // Maximum value for participant assessment
            // var maxPracticalAssessment = 36; // Maximum value for practical assessment
            var maxTheoryAssessment = fullMarks;
            row.find('input.theory_assessment').attr('max', maxTheoryAssessment);
        }

        // Initial setup
        $('.attendance_chk').each(function() {
            var row = $(this).closest('tr');
            var isPresent = $(this).is(':checked');

            // Set initial state of input fields based on attendance
            toggleInputFields(row, isPresent);

            // Update the max value for theory assessment
            updateTheoryAssessmentMax(row);
        });

        // Handle checkbox change
        $('.attendance_chk').change(function() {
            var row = $(this).closest('tr');
            var isPresent = $(this).is(':checked');

            // Update the hidden attendance input
            row.find('input[name^="attendance"][type="hidden"]').val(isPresent ? '0' : '1');

            // Enable input fields only if the student is present
            toggleInputFields(row, isPresent);

            // Update the max value for theory assessment
            updateTheoryAssessmentMax(row);
        });

        // Enforce max and min limits on input fields
        $('input.participant_assessment, input.practical_assessment').on('input', function() {
            var row = $(this).closest('tr');
            var participantAssessment = parseFloat(row.find('input.participant_assessment').val());
            var practicalAssessment = parseFloat(row.find('input.practical_assessment').val());

            if (participantAssessment > 4) {
                row.find('input.participant_assessment').val(4);
                row.find('.participant-assessment-error').text('Max limit is 4').show();
            } else if (participantAssessment < 0) {
                row.find('input.participant_assessment').val(0);
                row.find('.participant-assessment-error').text('Cannot be negative').show();
            } else {
                row.find('.participant-assessment-error').hide();
            }

            if (practicalAssessment > 36) {
                row.find('input.practical_assessment').val(36);
                row.find('.practical-assessment-error').text('Max limit is 36').show();
            } else if (practicalAssessment < 0) {
                row.find('input.practical_assessment').val(0);
                row.find('.practical-assessment-error').text('Cannot be negative').show();
            } else {
                row.find('.practical-assessment-error').hide();
            }

            // Update the max value for theory assessment after changes in other assessments
            updateTheoryAssessmentMax(row);
        });

        $('input.theory_assessment').on('input', function() {
            var row = $(this).closest('tr');
            var value = parseFloat($(this).val());
            var maxTheoryAssessment = parseFloat($(this).attr('max'));

            if (isNaN(value)) {
                $(this).val('');
                row.find('.theory-assessment-error').text('Please enter a valid number').show();
            } else if (value > maxTheoryAssessment) {
                $(this).val(maxTheoryAssessment);
                row.find('.theory-assessment-error').text('Max limit is ' + maxTheoryAssessment).show();
            } else if (value < 0) {
                $(this).val(0);
                row.find('.theory-assessment-error').text('Cannot be negative').show();
            } else {
                row.find('.theory-assessment-error').hide();
            }
        });

        // Function to toggle input fields
        function toggleInputFields(row, isEnabled) {
            row.find('input.participant_assessment, input.practical_assessment, input.theory_assessment, input.note')
               .prop('disabled', !isEnabled);
        }

        // CSV Export Function
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV FILE
            csvFile = new Blob([csv], { type: 'text/csv' });

            // DOWNLOAD LINK
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide the link
            downloadLink.style.display = "none";

            // Add the link to the DOM
            document.body.appendChild(downloadLink);

            // Click the link to download the file
            downloadLink.click();
        }

        function exportTableToCSV(filename) {
            var csv = [];
            var table = document.getElementById("subjectTable");
            var rows = table.querySelectorAll("tr");

            // Loop through each row
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var cols = row.querySelectorAll("td, th");
                var csvRow = [];

                // Loop through each column
                for (var j = 0; j < cols.length; j++) {
                    csvRow.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
                }

                csv.push(csvRow.join(","));
            }

            // Download CSV
            downloadCSV(csv.join("\n"), filename);
        }

        // Event listener for the export button
        $("#exportCsv").on("click", function() {
            exportTableToCSV('subject_marks.csv');
        });
    });
</script>