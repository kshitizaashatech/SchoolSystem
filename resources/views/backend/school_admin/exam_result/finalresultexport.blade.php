<table>
    <thead>
        <tr>
            <th>Admission No</th>
            <th>Roll No</th>
            <th>Student Name</th>
            <th>Father Name</th>
            <th>Class</th>
            <th>Section</th>
            @foreach ($examinations->subjectByRoutine as $routine)
                <th colspan="5">{{ $routine->subject }}</th>
            @endforeach
            <th>GPA</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <!-- Headers for practical, theory, grade point, and total for each subject -->
            @foreach ($examinations->subjectByRoutine as $routine)
                <th>Internal (IN)</th>
                <th>Theory (TH)</th>
                <th>Total</th>
                <th>Grade Point</th>
                <th>Grade</th>
            @endforeach
            <th></th>
        </tr>
    </thead>
    <tbody id="studentTableBody">
        @foreach ($studentSessions as $studentSession)
            <tr>
                <td>{{ $studentSession->admission_no }}</td>
                <td>{{ $studentSession->roll_no }}</td>
                <td>{{ $studentSession->f_name . ' ' . $studentSession->m_name . ' ' . $studentSession->l_name }}
                </td>
                <td>{{ $studentSession->father_name }}</td>

                <td>{{ $studentSession->class }}</td>
                <td>{{ $studentSession->section_name }}</td>
                @foreach ($examinations->subjectByRoutine as $routine)
                    @php
                        $resultData = $studentSession->SubjectWiseExamResults(
                            $examinations,
                            $routine->id,
                            $studentSession,
                        );
                        // dd($resultData);
                    @endphp
                    {{-- <td>{{ $resultData['examResult'] ? $resultData['examResult']->participant_assessment : '-' }}
                                                            </td> --}}
                    <td>{{ $resultData['examResult'] ? $resultData['examResult']->internal_total : '-' }}
                    </td>
                    <td>{{ $resultData['examResult'] ? $resultData['examResult']->theory_assessment : '-' }}
                    </td>
                    <td>{{ $resultData['examResult'] ? $resultData['examResult']->total_terminal_final_marks : '-' }}
                    </td>
                    <td>{{ $resultData['grade'] ? $resultData['grade']->grade_points_to : '-' }}
                    </td>
                    <td>{{ $resultData['grade'] ? $resultData['grade']->grade_name : '-' }}
                    </td>
                @endforeach
                <td>{{ $studentSession->GPACalculation() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
