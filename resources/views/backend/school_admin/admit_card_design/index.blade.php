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
        @include('backend.school_admin.admit_card_design.partials.action')
    </div>

    <!-- MODAL FOR ADMIT CARD DESIGN -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg landscape-modal" role="document">
            <!-- Add 'landscape-modal' class for custom styling -->
            {{-- <div class="modal-content" id="modalContent"
                style="background-image: url(''); background-size: cover;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AdmitCard - <span id="modalHeading"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal body content goes here -->
                </div>
            </div> --}}

            <div class="modal-content" id="modalContent" style="background-image: url(''); background-size: cover;">
                <div class="modal-header">

                    <h4 class="modal-title">View Admit Card</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="certificate_detail">





                    {{-- <img src="" id="modalLeftLogo" alt="Left Logo"
                    style="position: absolute; top: 20; left: 20; height: 50px;"> --}}



                    <div class="mark-container">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" align="center" width="100">
                                                        <img src="" alt="Left Logo" id="modalLeftLogo"
                                                            width="100" height="100">
                                                    </td>
                                                    <td valign="top">
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="font-size: 26px; font-weight: bold; text-align: center; text-transform: uppercase; padding-top: 10px;">
                                                                        <span id="modalSchoolName"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"
                                                                        style="font-size: 20px;text-align: center; text-transform: uppercase; text-decoration: underline;">
                                                                        <span id="modalExamName"></span>

                                                                        </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td width="100" valign="top" align="center">
                                                        <img src="" alt="Right Logo" id="modalRightLogo"
                                                            width="100" height="100">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td valign="top"
                                        style="text-align: center; text-transform: capitalize; text-decoration: underline; font-weight: bold; padding-top: 5px;">
                                        May-June 2024 Examinations </td>
                                </tr> --}}
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
                                                                    <td valign="top" style="padding-bottom: 10px;">
                                                                        School Name</td>
                                                                    <td valign="top" colspan="3"
                                                                        style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">                                  <span id="modalSchoolName"></span></td>

                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" style="padding-bottom: 10px;">Exam
                                                                        Center</td>
                                                                    <td valign="top" colspan="3"
                                                                        style="text-transform: uppercase; font-weight: bold;padding-bottom: 10px;">
                                                                        <span id="modalExamCenter"></span></td>
                                                                </tr>

                                                                <tr id="is_dob" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        DOB<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>29th April
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isName" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Name<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Niha
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isMotherName" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">
                                                                        Mother
                                                                        Name<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Taylor
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isFatherName" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">
                                                                        Father
                                                                        Name<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Harry
                                                                            </span></span>
                                                                    </td>

                                                                </tr>



                                                                <tr id="isAdmissionNumber" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Admission Number<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>11789
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isRollNo" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Roll Number<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>9
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isAddress" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Address<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Kathmandu
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isGender" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Gender<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Female
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isPhoto" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Photo<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Photo
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isClass" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Class<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>3
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isSession" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Session<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>2021
                                                                            </span></span>
                                                                    </td>

                                                                </tr>

                                                                <tr id="isContentFooter" style="display: none;">
                                                                    <td valign="top"
                                                                        style="text-transform: uppercase; padding-bottom: 15px;">

                                                                        Footer<span
                                                                            style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Taylor
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
                                        <table cellpadding="0" cellspacing="0" width="100%" class="denifittable">
                                            <tbody>
                                                <tr>
                                                    <th valign="top"
                                                        style="text-align: center; text-transform: uppercase;">Theory
                                                        Exam Date &amp; Time</th>
                                                    <th valign="top"
                                                        style="text-align: center; text-transform: uppercase;">Paper
                                                        Code</th>
                                                    <th valign="top"
                                                        style="text-align: center; text-transform: uppercase;">Subject
                                                    </th>
                                                    <th valign="top"
                                                        style="text-align: center; text-transform: uppercase;">Obtained
                                                        By Student</th>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="text-align: center;">03-Jun-2024 2 P.M. - 5
                                                        P.M.</td>
                                                    <td style="text-align: center;text-transform: uppercase;">7713</td>
                                                    <td style="text-align: center;text-transform: uppercase;">
                                                        Mathematics</td>
                                                    <td style="text-align: center;text-transform: uppercase;">TH</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="text-align: center;">03-Jun-2024 2 P.M. - 5
                                                        P.M.</td>
                                                    <td style="text-align: center;text-transform: uppercase;">7714</td>
                                                    <td style="text-align: center;text-transform: uppercase;">Sceince
                                                    </td>
                                                    <td style="text-align: center;text-transform: uppercase;">TH</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="text-align: center;">03-Jun-2024 2 P.M. - 5
                                                        P.M.</td>
                                                    <td style="text-align: center;text-transform: uppercase;">7715</td>
                                                    <td style="text-align: center;text-transform: uppercase;">English
                                                    </td>
                                                    <td style="text-align: center;text-transform: uppercase;">TH</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="text-align: center;">03-Jun-2024 2 P.M. - 5
                                                        P.M.</td>
                                                    <td style="text-align: center;text-transform: uppercase;">7716</td>
                                                    <td style="text-align: center;text-transform: uppercase;">Social
                                                        Science</td>
                                                    <td style="text-align: center;text-transform: uppercase;">TH</td>
                                                </tr>
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
                                <tr>
                                    <td align="right" valign="top">
                                        <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top">
                                                        <img src="" alt="Middle logo" id="modalMiddleSign"
                                                            width="100" height="38">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
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





    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">

                            <div class="table-responsive">
                                <table id="admit_card_design-table"
                                    class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Heading</th>
                                            <th>Title</th>
                                            <th>Exam Name</th>
                                            <th>School Name</th>
                                            <th>Exam Center</th>
                                            <th>Status</th>
                                            <th>Created At</th>
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

    <script>
        $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#admit_card_design-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.admit-carddesigns.get') }}',
                type: 'post'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'heading',
                    name: 'heading'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'exam_name',
                    name: 'exam_name'
                },
                {
                    data: 'school_name',
                    name: 'school_name'
                },
                {
                    data: 'exam_center',
                    name: 'exam_center'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
    });
    </script>
    @endsection
