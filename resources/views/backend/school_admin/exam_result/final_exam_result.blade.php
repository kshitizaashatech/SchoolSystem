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
                                    <th colspan="4" class="text-center bg-primary text-white">{{ $subject->subject ?? 'N/A' }}</th>
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
                                    <th>Internal Marks</th>
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
                                            $firstTermResult = $firstTermResults[$session->id][$subject->id] ?? null;
                                            $secondTermResult = $secondTermResults[$session->id][$subject->id] ?? null;
                                            $creditHours = $subject->examSchedule->credit_hour ?? 1;

                                            if ($result) {
                                                // Calculate 5% of first term total
                                                // $firstTermTotal = $firstTermResult ? 
                                                //     ($firstTermResult->participant_assessment + 
                                                //      $firstTermResult->practical_assessment + 
                                                //      $firstTermResult->theory_assessment) * 0.05 : 0;

                                                     $firstTermTotal = $firstTermResult ? 
                                                    ( 
                                                     $firstTermResult->theory_assessment) * 0.05 : 0;

                                                 // Calculate 5% of second term total
                                                 $secondTermTotal = $secondTermResult ? 
                                                    (
                                                     $secondTermResult->theory_assessment) * 0.05 : 0;

                                                // Calculate internal marks
                                                $internalMarks = $firstTermTotal + $secondTermTotal +
                                                                $result->participant_assessment +
                                                                $result->practical_assessment;

                                                // Convert theory marks to 50%
                                                $theoryMarks = $result->theory_assessment * 0.5;

                                                // Calculate total
                                                $totalMarks = $internalMarks + $theoryMarks;

                                                $gpa = calculateGPA($totalMarks);

                                                $totalCreditHours += $creditHours;
                                                $totalGradePoints += $gpa * $creditHours;
                                            }
                                        @endphp
                                        @if ($result)
                                            <td>{{ number_format($internalMarks, 2) }}</td>
                                            <td>{{ number_format($theoryMarks, 2) }}</td>
                                            <td>{{ number_format($totalMarks, 2) }}</td>
                                            <td>{{ number_format($gpa, 2) }}</td>
                                        @else
                                            <td colspan="4" class="text-center text-muted">N/A</td>
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
        function calculateGPA($totalMarks) {
            if ($totalMarks > 90) return 4.0;
            elseif ($totalMarks > 80) return 3.6;
            elseif ($totalMarks > 70) return 3.2;
            elseif ($totalMarks > 60) return 2.8;
            elseif ($totalMarks > 50) return 2.4;
            elseif ($totalMarks > 40) return 2.0;
            elseif ($totalMarks > 32) return 1.6;
            else return 0.0;
        }
    @endphp
@endsection
