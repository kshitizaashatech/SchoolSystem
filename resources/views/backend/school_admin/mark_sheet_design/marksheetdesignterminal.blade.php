<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradesheet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/algeria');

        :root {
            --input-color: rgb(39, 60, 223);
        }

        .s_name,
        .s_exam,
        .s_estd,
        .s_sheet {
            font-family: "Times New Roman", Times, serif;
            font-size: 25px;
            font-weight: bolder;
        }

        .s_address,
        .s_state {
            font-family: "Times New Roman", Times, serif;
            font-size: 15px;
            font-weight: bolder;
        }

        .gradesheet {
            border: 5px solid var(--input-color);
        }

        .gradesheet_design {
            border: 2px solid var(--input-color);
            padding: 20px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .gradesheet_logo {
            margin-top: 55px;
            height: 150px;
        }

        .s_name,
        .s_address,
        .s_state,
        .s_estd,
        .s_exam,
        .s_sheet,
        .input,
        .first-input,
        .interval-grades,
        .one-credit,
        .foot-input {
            color: var(--input-color);
        }

        .foot-input {
            border-top: 1px dashed var(--input-color);
        }

        .one-credit {
            line-height: 30px;
        }

        .interval-grades {
            height: 40px;
            line-height: 1px;
        }

        .output {
            border-bottom: 1px dashed var(--input-color);
        }

        .first-input {
            font-weight: bold;
        }

        .first-input,
        .output {
            padding: 0px 0px;
            height: 25px;
        }

        .credit,
        .grade {
            border: 1px solid red;
            width: 10px;
        }

        .s_sheet {
            font-family: 'Algeria', sans-serif;
            font-size: 40px;
        }

        #printButton {
            position: relative;
            top: 10px;
            right: 20px;
        }

        @media print {
            #printButton {
                display: none !important;
            }
        }
    </style>
</head>

<body>
 
    <section class="gradesheet">
        <div class="container">
            <button id="printButton" class="btn btn-primary">Print Gradesheet</button>
            <div class="gradesheet_design">
                <div class="row gradesheet_head">
                    <div class="col-2">
                        <img class="gradesheet_logo" src="{{ asset('uploads/' . $logoFilename) }}" alt="School Logo">
                    </div>
                    <div class="text-center col-8">
                        <p>
                            <span class="s_name">{{ $school->name }}</span><br>
                            <span class="s_address">{{ $school->address }}</span><br>
                            <span class="s_state">{{ $school->district->name }}, Nepal</span><br>
                            <span class="s_estd">Estd: {{ $school->established_date }}</span><br>
                            <span class="s_exam">{{ $examinations->exam }}</span><br>
                            <span class="s_sheet">GRADE - SHEET</span>
                        </p>
                    </div>
                    <div class="col-2"></div>
                </div>

                <div class="row mb-4">
                    <div class="col-4 first-input">
                        <p>THE GRADE SECURED BY:</p>
                    </div>
                    <div class="col-8 output text-center">
                        <p>
                            @if($student)
                                {{ $student->f_name . ' ' . $student->m_name . ' ' . $student->l_name }}
                            @else
                                Student information not available
                            @endif
                        </p>
                    </div>

                    <div class="col-3 first-input">
                        <p>CHILD OF</p>
                    </div>
                    <div class="col-3 output text-center">
                        <p>{{ $student->father_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-3 first-input">
                        <p>AND</p>
                    </div>
                    <div class="col-3 output text-center">
                        <p>{{ $student->mother_name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-2 first-input">
                        <p>DOB:</p>
                    </div>

                    <div class="col-2 output text-center">
                        <p>{{ $student->dob ?? 'N/A' }}</p>
                    </div>

                    <div class="col-2 first-input">
                        <p>ROLL NO:</p>
                    </div>

                    <div class="col-2 output text-center">
                        <p>{{ $studentDetails->roll_no ?? 'N/A' }}</p>
                    </div>

                    <div class="col-2 first-input">
                        <p>GRADE:</p>
                    </div>

                    <div class="col-2 output text-center">
                        <p>{{ $className ?? 'N/A' }} {{ $sectionName ?? 'N/A' }}</p>
                    </div>
                    <div class="col-5 first-input">
                        <p>IN THE {{ strtoupper($examinations->exam) }}</p>
                    </div>

                    <div class="col-4 first-input">
                        <p>ARE GIVEN BELOW.</p>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="input">S.N.</th>
                                <th scope="col" class="input">SUBJECTS</th>
                                <th scope="col" class="input">Marks Distribution</th>
                                <th scope="col" class="input">Marks Obtained</th>
                                <th scope="col" class="input credit">TOTAL</th>
                                <th scope="col" class="input grade">GRADE POINT</th>
                                <th scope="col" class="input grade">GRADE</th>
                                <th scope="col" class="input">REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $allZero = true;
                            @endphp
                            @foreach ($examResults as $index => $resultData)
                                @php
                                    $subjectAllZero = ($resultData['participant_assessment'] == 0 && 
                                                       $resultData['practical_assessment'] == 0 && 
                                                       $resultData['theory_assessment'] == 0);
                                    $allZero = $allZero && $subjectAllZero;
                                @endphp
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <th scope="row" class="text-center">
                                        {{ $resultData['subject_name'] ?? 'N/A' }}
                                    </th>
                                    <td>
                                        Participant Marks<br>
                                        Practical Marks<br>
                                        Theory Marks
                                    </td>
                                    <td class="text-center">
                                        {{ $resultData['participant_assessment'] }}<br>
                                        {{ $resultData['practical_assessment'] }}<br>
                                        {{ number_format($resultData['converted_theory'], 2) }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($resultData['total'], 2) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $subjectAllZero ? '0.00' : $resultData['grade_point'] }} 
                                    </td>
                                    <td class="text-center">
                                        {{ $resultData['grade']['grade_name'] ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $resultData['grade']['achievement_description'] ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="8">
                                    <b><span class="input">GRADE POINT AVERAGE (GPA):</span>
                                        @if ($allZero)
                                            0.00
                                        @else
                                            {{ number_format($gpa, 2) }}
                                        @endif
                                    </b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p class="one-credit">
                            1. One Credit Hour Equals To 32 Working Hours. <br>
                            2. INTERNAL <b>(IN)</b>: This Covers The Participation Practical/Project
                            Works & Terminal Examination.<br>
                            3. EXTERNAL <b>(TH)</b>: This Covers Written External Examination.<br>
                            4. <b>ABS</b>: Absent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5. <b>*NG</b> :
                            Not Graded<br>
                            6. <b>GPA</b> = Σ ( Credit Hour × Grade Point )/Total Credit Hour Of The
                            Grade
                        </p>
                        <p>
                            <span class="input"> Attendance:</span> {{ $studentSessions->attendance_percentage ?? 'N/A' }} <br>
                            <span class="input">Result:</span> {{ $studentSessions->result_status ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-6">
                        <table class="table table-bordered interval-grades">
                            <thead>
                                <p class="text-center input"> Interval And Grades</p>
                                <tr>
                                    <th scope="col">S.N.</th>
                                    <th scope="col">Interval In %</th>
                                    <th scope="col">GRADE</th>
                                    <th scope="col">Detail</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($markgrades as $grade)
                                    <tr>
                                        <th scope="row">{{ $grade->id }}</th>
                                        <td>
                                            {{ $grade->percentage_from }} - {{ $grade->percentage_to }}
                                        </td>
                                        <td>
                                            {{ $grade->grade_name }}
                                        </td>
                                        <td>
                                            {{ $grade->achievement_description }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row text-center mt-5 justify-content-around">
                    <div class="col-3 foot-input">
                        <p>TARANATH KHANAL</p>
                        <p>PREPARED BY</p>
                    </div>
                    <div class="col-3 foot-input">
                        <em class="input">Date Of Issue:</em> {{ $today->format('Y-m-d') }}
                    </div>
                    <div class="col-3 foot-input">
                        <p>{{ $school->head_teacher }}</p>
                        <p>APPROVED BY</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>

</html>
