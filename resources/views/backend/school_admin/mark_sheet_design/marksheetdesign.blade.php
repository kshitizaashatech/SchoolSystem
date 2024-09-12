    <div class="modal fade" id="marksheetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modalContent" style="background-image: url(''); background-size: cover;">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marksheet - <span id="modalHeading"></span></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table cellpadding="0" cellspacing="0" width="100%" style="border: black solid 2px">
                        <tbody>
                            <tr>
                                <td valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <!-- Left Logo -->
                                                <td valign="top" style="position: relative;">
                                                    <img src="data:image/png;base64,{{ $base64EncodedImageLeft }}" id="modalLeftLogo" alt="Left Logo" style="position: absolute; top: 20px; left: 20px; height: 100px;">
                                                </td>

                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="font-size: 20px; font-weight: bold; text-align: center; text-transform: uppercase;" colspan="3">
                                                                    <span id="modalExamName"></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" height="5"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>

                                                <!-- Spacer -->
                                                <td valign="top" style="width: 100%;"></td>

                                                <!-- Right Logo -->
                                                <td valign="top" style="position: relative;">
                                                    <img src="data:image/png;base64,{{ $base64EncodedImageRight }}" id="modalRightLogo" alt="Right Logo" style="position: absolute; top: 20px; right: 20px; height: 100px;">
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
                                    <table cellpadding="0" cellspacing="0" width="100%" class="">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%" class="">
                                                        <tbody>
                                                            <tr>


                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" colspan="5" style="text-align: center; text-transform: uppercase; border:0">

                                                                    Certificated That</td>
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
                                <td valign="top" height="5"></td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%" class="">
                                        <tbody>
                                            <tr>
                                                {{-- @if($isName == 1) --}}
                                                <tr id="isName">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px; padding-top: 80px; ">
                                                    Mr/Ms<span style="padding-left: 30px; font-weight: bold;"><span id="isName"></span></span></td>
                                                {{-- </tr> --}}
                                                {{-- @endif --}}


                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    School
                                                    Name<span style="padding-left: 30px; font-weight: bold;">{{ $student->school->name}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Exam
                                                    Center<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;">Exam center</span>
                                                </td>
                                            </tr>


                                            <tr>

                                            <tr id="classteacherRemarks" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Class
                                                    Teacher Remarks<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span id="classteacherRemarks">
                                                        </span></span>
                                                </td>

                                            </tr>


                                            {{-- <tr id="isName" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span> Taylor
                                                        </span></span>
                                                </td>

                                            </tr> --}}
                                            @if($marksheet->is_name == 1)
                                                <tr id="isName">
                                                    <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                        Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->f_name }}</span></span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if($marksheet->is_father_name == 1)
                                            <tr id="isFatherName">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Father Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->father_name }}</span></span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if($marksheet->is_mother_name == 1)
                                        <tr id="isMotherName">
                                            <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                Mother Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->mother_name }}</span></span>
                                            </td>
                                        </tr>
                                    @endif


                                            <tr id="isPhoto" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Photo
                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>photo
                                                        </span></span>
                                                </td>

                                            </tr>



                                        @if($marksheet->is_dob == 1)
                                        <tr id="isMotherName">
                                            <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                DOB<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->dob }}</span></span>
                                            </td>
                                        </tr>
                                    @endif



                                            @if($marksheet->is_admission_no == 1)
                                            <tr id="isMotherName">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Admission No<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->admission_no }}</span></span>
                                                </td>
                                            </tr>
                                        @endif



                                            @if($marksheet->is_roll_no == 1)
                                            <tr id="isRollNo">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Roll No<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->roll_no }}</span></span>
                                                </td>
                                            </tr>
                                        @endif


                                            @if($marksheet->is_address == 1)
                                            <tr id="isAddress">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Address<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->local_address }}</span></span>
                                                </td>
                                            </tr>
                                        @endif


                                            @if($marksheet->is_gender == 1)
                                            <tr id="isGender">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Gender<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->user->gender }}</span></span>
                                                </td>
                                            </tr>
                                        @endif



                                        @if($marksheet->is_division == 1)
                                        <tr id="isDivision">
                                            <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                Division<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>FIRST</span></span>
                                            </td>
                                        </tr>
                                    @endif

                                    @if($marksheet->is_rank == 1)
                                    <tr id="isRank">
                                        <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                            Rank<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>FIRST</span></span>
                                        </td>
                                    </tr>
                                @endif

                                @if($marksheet->is_custom_field == 1)
                                <tr id="isRank">
                                    <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                        Custom Field<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>CF</span></span>
                                    </td>
                                </tr>
                            @endif

                            @if($marksheet->is_class == 1)
                            <tr id="isClass">
                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                    Class<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>{{ $student->class_id}}</span></span>
                                </td>
                            </tr>
                        @endif


                        @if($marksheet->is_session == 1)
                        <tr id="isSession">
                            <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                Session<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>2024</span></span>
                            </td>
                        </tr>
                    @endif

                            </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>


                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" class="denifittable" style="text-align: center; text-transform: uppercase;">
                                <tbody>
                                    <tr>
                                        <th valign="middle" style="width:35%;">Subjects</th>
                                        <th valign="middle" style="text-align: center;">Max Marks</th>
                                        <th valign="middle" style="text-align: center;">Min Marks</th>

                                        <th valign="top" style="text-align: center;">Participant Assessment</th>
                                        <th valign="top" style="text-align: center;">Practical Assessment</th>
                                        <th valign="top" style="text-align: center;">Theory Assessment</th>
                                        <th valign="middle" style="border-right:1px solid #999; text-align: center;">Remarks</th>
                                    </tr>
                                    @foreach($examSchedules as $schedule)
                                    <tr>
                                        {{-- {{ dd($examSchedules) }} --}}
                                        <td valign="top" style="text-align: left;">{{ $schedule->subject->subject}}</td>
                                        <td valign="top" style="text-align: center;">{{ $schedule->full_marks}}</td>
                                        <td valign="top" style="text-align: center;">{{ $schedule->pass_marks}}</td>



                                        {{-- <td valign="top" style="text-align: center;">1002</td>
                                        <td valign="top" style="text-align: center;">76</td>
                                        <td valign="top" style="text-align: center;">78</td> --}}
                                     {{-- @foreach($studentSessions as $session)
                                     @if($session->exam_schedule_id == $schedule->id)
                                    <td valign="top" style="text-align: left;">{{ $session->practical_assessment }} </td>
                                     <td valign="top" style="text-align: center;"> {{ $session->theory_assessment }}</td>
                                     <td valign="top" style="text-align: center;">{{ $session->participant_assessment }}</td>
                                     @endif
                                    @endforeach --}}
                                    @foreach($studentSessions as $session)
                                    {{-- {{ dd($studentSessions)}} --}}

                                        <td valign="top" style="text-align: left;">{{ $session->practical_assessment }}</td>
                                        <td valign="top" style="text-align: center;">{{ $session->theory_assessment }}</td>
                                        <td valign="top" style="text-align: center;">{{ $session->participant_assessment }}</td>

                                 @endforeach

                                        <td valign="top" style="text-align: center;border-right:1px solid #999;">Distin</td>

                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td valign="top" colspan="5" width="20%" style="font-weight: normal; text-align: left; border-right: 1px solid #999;">Grand Marks: <span style="text-align: left;font-weight: bold; padding-left: 30px;">284</span></td>
                                    </tr>

                                    <tr>
                                        <td valign="top" colspan="5" width="20%" style="font-weight: normal; text-align: left; border-right: 1px solid #999;">Grand Total In Words: <span style="text-align: left;font-weight: bold; padding-left: 30px;">Two hundred eighty four</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" height="10"></td>
                    </tr>
                    <tr>
                        <td valign="top" style="font-weight: bold; padding-left: 30px; padding-top: 10px;">
                            17-Mar-1988
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" height="30"></td>
                    </tr>
                    <tr>


                        <td>
                            <div class="main-div-marksheet">
                                <div class="left-sign">
                                    <img src="data:image/png;base64,{{ $base64EncodedImageLeftSign }}" alt="Left Sign" id="modalLeftSign">
                                </div>
                                <div class="middle-sign">
                                    <img src="data:image/png;base64,{{ $base64EncodedImageMiddleSign }}" alt="Middle Sign" id="modalMiddleSign">
                                </div>
                                <div class="right-sign">
                                    <img src="data:image/png;base64,{{ $base64EncodedImageRightSign }}" alt="Right Sign" id="modalRightSign">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" class="">
                                <tbody>
                                    <tr>
                                        <td valign="bottom" style="font-size: 12px;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" height="20"></td>
                    </tr>
                    </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
    {{-- @endforeach --}}
    {{-- MODAL FOR MARKSHEET DESIGN END--}}
