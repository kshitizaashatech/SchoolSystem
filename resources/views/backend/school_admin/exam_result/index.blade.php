@extends('backend.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h1>{{ $page_title }}</h1>
            </div>
            @include('backend.school_admin.exam_result.partials.action')
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Admission No</th>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                @foreach ($examinations->subjectByRoutine as $subject)
                                    <th colspan="5" class="text-center bg-primary text-white">{{ $subject->subject ?? 'N/A' }}</th>
                                @endforeach
                                <th class="text-center bg-primary text-white">Overall GPA</th>
                            </tr>
                            <tr class="bg-secondary text-white">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                @foreach ($examinations->subjectByRoutine as $subject)
                                    <th>Participant Marks</th>
                                    <th>Practical Marks</th>
                                    <th>Theory Marks</th>
                                    <th>Total</th>
                                    <th>Grade points</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentSessions as $session)
                                @php
                                    $totalCreditHours = 0;
                                    $totalGradePoints = 0;
                                @endphp
                                <tr>
                                    <td>{{ $session->student->admission_no }}</td>
                                    <td>{{ $session->student->roll_no }}</td>
                                    <td>{{ $session->student->user->f_name }}</td>
                                    <td>{{ $session->classg->class }}</td>
                                    <td>{{ $session->section->section_name }}</td>
                                    @foreach ($examinations->subjectByRoutine as $subject)
                                        @php
                                            $result = $restructuredResults[$session->id][$subject->id] ?? null;
                                            $creditHours = $subject->examSchedule->credit_hour ?? 1; // Fetch credit hours
                                            // Convert theory_assessment marks to a scale of 10
                                            $normalizedTheoryMarks = $result ? ($result->theory_assessment * 10 / 50) : null;
                                            $gpa = $result ? calculateGPA($result->participant_assessment, $result->practical_assessment, $normalizedTheoryMarks) : null;

                                            if ($gpa !== null) {
                                                $totalCreditHours += $creditHours;
                                                $totalGradePoints += $gpa * $creditHours;
                                            }
                                        @endphp
                                        @if ($result)
                                            <td>{{ $result->participant_assessment }}</td>
                                            <td>{{ $result->practical_assessment }}</td>
                                            <td>{{ number_format($normalizedTheoryMarks, 2) }}</td>
                                            <td>{{ $result->participant_assessment + $result->practical_assessment + $normalizedTheoryMarks }}</td>
                                            <td>{{ $gpa ? number_format($gpa, 2) : 'N/A' }}</td>
                                        @else
                                            <td colspan="5" class="text-center text-muted">N/A</td>
                                        @endif
                                    @endforeach
                                    <td class="text-center font-weight-bold">{{ number_format($totalCreditHours ? $totalGradePoints / $totalCreditHours : 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @php
        function calculateGPA($participantAssessment, $practicalAssessment, $theoryAssessment) {
            $totalMarks = $participantAssessment + $practicalAssessment + $theoryAssessment;
            $gpa = 0;
            if ($totalMarks > 45) {
                $gpa = 4.0;
            } elseif ($totalMarks > 40) {
                $gpa = 3.6;
            } elseif ($totalMarks > 35) {
                $gpa = 3.2;
            } elseif ($totalMarks > 30) {
                $gpa = 2.8;
            } elseif ($totalMarks > 25) {
                $gpa = 2.4;
            } elseif ($totalMarks > 20) {
                $gpa = 2.0;
            } elseif ($totalMarks > 18) {
                $gpa = 1.6;
            } else {
                $gpa = 0.0;
            }

            return $gpa;
        }
    @endphp
@endsection
