<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg landscape-modal" role="document">

        <div class="modal-content">

            <div class="modal-header d-flex">
                <h4 class="modal-title me-auto">View Admit Card</h4>
                @unless ($isPdfDownload)
                    <!-- Conditionally exclude the print button -->
                    <div class="ms-auto">
                        <button class="print-window btn btn-primary" onclick="printModalContent()"
                            id="printButton">Print</button>
                    </div>
                @endunless
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>



            <div class="modal-body" id="certificate_detail">

                <div class="mark-container"
                    style="background-image: url('data:image/png;base64,{{ $base64EncodedBackgroundImage }}'); background-size: cover; background-position: center; opacity: 0.7;">
                    <table cellpadding="0" cellspacing="0" width="100%" class="main-table" style="padding:10px;">
                        <tbody>
                            <tr>
                                <td valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top" align="center" width="100">
                                                    <img src="data:image/png;base64,{{ $base64EncodedImageLeft }}"
                                                        width="100" height="100">
                                                </td>
                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top"
                                                                    style="font-size: 26px; font-weight: bold; text-align: center; text-transform: uppercase; padding-top: 10px;">
                                                                    <span id=""></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" height="5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top"
                                                                    style="font-size: 20px;text-align: center; text-transform: uppercase; text-decoration: underline;">
                                                                    <span id="modalExamName"
                                                                        style="color: black;">{{ $examination->exam }}</span>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="100" valign="top" align="center">
                                                    {{-- src="{{ asset('uploads/students/admit_card/' . $admitCard->right_logo) }}" --}}
                                                    <img src="data:image/png;base64,{{ $base64EncodedImageRight }}"
                                                        width="100" height="100">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" height="10"></td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%"
                                        style="text-transform: uppercase;">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top"
                                                                    style="text-transform: uppercase; padding-bottom: 15px; color: black; font-weight: bold;">
                                                                    School Name<span
                                                                        style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                        <span> {{ $student->school_id }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top"
                                                                    style="padding-bottom: 10px;color: black; font-weight: bold;">
                                                                    Exam
                                                                    Center</td>
                                                                <td valign="top" colspan="3"
                                                                    style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                    <span id="modalExamCenter"
                                                                        style="color: black;"></span>
                                                                </td>
                                                            </tr>


                                                            @if ($admitCard->is_dob == 1 && !empty($student->user->dob))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        DOB

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->user->dob }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                            @if ($admitCard->is_name == 1 && !empty($student->user->f_name))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px; color: black; font-weight: bold;">
                                                                        Name

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->user->f_name }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif



                                                            @if ($admitCard->is_mother_name == 1 && !empty($student->user->mother_name))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px; color: black; font-weight: bold;">
                                                                        Mother Name<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            <span>
                                                                                {{ $student->user->mother_name }}</span></span>
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                            @if ($admitCard->is_father_name == 1 && !empty($student->user->father_name))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px; color: black; font-weight: bold;">
                                                                        Father Name<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            <span>
                                                                                {{ $student->user->father_name }}</span></span>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            <tr id="">
                                                                <td valign="top"
                                                                    style="text-transform: uppercase; padding-bottom: 15px; color: black; font-weight: bold;">

                                                                    Admission Number<span
                                                                        style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                        <span> {{ $student->admission_no }}
                                                                        </span></span>
                                                                </td>

                                                            </tr>



                                                            @if ($admitCard->is_roll_no == 1 && !empty($student->roll_no))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        Roll No

                                                                        <span valign="top" colspan="3"
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->roll_no }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                            @if ($admitCard->is_address == 1 && !empty($student->user->local_address))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        Address

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->user->local_address }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                            @if ($admitCard->is_gender == 1 && !empty($student->user->gender))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        Gender

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->user->gender }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            @if ($admitCard->is_photo == 1 && !empty($student->student_photo))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        Photo

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->student_photo }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif




                                                            @if ($admitCard->is_class == 1 && !empty($student->class_id))
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">
                                                                        Class

                                                                        <span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px; color:black;">
                                                                            {{ $student->class_id }} </span>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            <tr id="isSession">
                                                                <td valign="top"
                                                                    style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">

                                                                    Session<span
                                                                        style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;color:black;"><span>1234
                                                                        </span></span>
                                                                </td>

                                                            </tr>

                                                            <tr id="isContentFooter">
                                                                <td valign="top"
                                                                    style="text-transform: uppercase; padding-bottom: 15px;color: black; font-weight: bold;">

                                                                    Footer<span
                                                                        style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;color:black;"><span>Taylor
                                                                        </span></span>
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="10"></td>
                            </tr>
                            <tr>
                                <td valign="top">

                                    <table cellpadding="0" cellspacing="0" width="100%" class="denifittable"
                                        style="border: 1px solid black; border-collapse: collapse;">
                                        <thead>
                                            <tr style="color: black;font-weight: bold;">
                                                <th valign="top"
                                                    style="text-align: center; text-transform: uppercase; border: 1px solid black;">
                                                    Theory Exam Date &amp; Time</th>
                                                <th valign="top"
                                                    style="text-align: center; text-transform: uppercase; border: 1px solid black;">
                                                    Subject Code</th>
                                                <th valign="top"
                                                    style="text-align: center; text-transform: uppercase; border: 1px solid black;">
                                                    Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color: black;">
                                            @foreach ($examSchedule as $schedule)
                                                <tr>
                                                    <td valign="top"
                                                        style="text-align: center; border: 1px solid black;">
                                                        {{ $schedule->exam_date }} {{ $schedule->exam_time }}</td>
                                                    <td
                                                        style="text-align: center; border: 1px solid black; text-transform: uppercase;">
                                                        {{ $schedule->subject->subject_code }}</td>
                                                    <td
                                                        style="text-align: center; border: 1px solid black; text-transform: uppercase;">
                                                        {{ $schedule->subject->subject }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="5"></td>
                            </tr>
                            <tr>
                                <td valign="top" height="20px"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
{{-- Modal end --}}


{{-- <script>
    // document.getElementById('printButton').addEventListener('click', function () {
    //     // Print the modal content
    //     window.print();
    // });
    function printModalContent() {
    // Clone the modal content
    var modalContent = document.querySelector('.modal-content').cloneNode(true);

    // Create a new window
    var printWindow = window.open('', '_blank');

    // Add HTML content to the new window

    printWindow.document.body.appendChild(modalContent);

    // Print the new window
    printWindow.print();

    // Close the new window after printing
    printWindow.close();
}

</script> --}}
<script>
    function printModalContent() {
        // Hide the print button
        var modalTitle = document.querySelector('.modal-title');
        var printButton = document.getElementById('printButton');
        var btnClose = document.querySelector('.btn-close');
        printButton.style.display = 'none';
        modalTitle.style.display = 'none';
        btnClose.style.display = 'none';

        // Clone the modal content
        var modalContent = document.querySelector('.modal-content').cloneNode(true);

        // Create a new window
        var printWindow = window.open('', '_blank');

        // Add HTML content to the new window
        printWindow.document.body.appendChild(modalContent);

        // Print the new window
        printWindow.print();

        // Restore the visibility of the print button after printing
        printButton.style.display = ''; // Set back to default (inherit)
    }
</script>
