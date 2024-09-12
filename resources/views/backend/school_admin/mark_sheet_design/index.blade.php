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
        @include('backend.school_admin.mark_sheet_design.partials.action')

    </div>

    {{-- model --}}

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Mark Sheet Design
    </button> --}}

    <!-- MODAL FOR MARKSHEET DESIGN -->
    {{-- @foreach($mark_sheet_design as $design) --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modalContent" style="background-image: url(''); background-size: cover;">
                {{-- <div class="modal-background" id="modalBackgroundImage"> --}}
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
                                                <td width="100" valign="top" align="center" style="padding-left: 0px;">
                                                </td>
                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">

                                                        <tbody>

                                                            <tr>
                                                                <td valign="top" style="font-size: 20px; font-weight: bold; text-align: center; text-transform: uppercase;" colspan="5" style="position: relative;">
                                                                    <span id="modalExamName"></span>
                                                                </td>

                                                                <!-- Left Logo -->
                                                                <img src="" id="modalLeftLogo" alt="Left Logo" style="position: absolute; top: 20; left: 20; height: 50px;">

                                                                <!-- Right Logo -->
                                                                <img src="" id="modalRightLogo" alt="Right Logo" style="position: absolute; top: 20; right:20; height: 50px;">
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" height="5"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="100" valign="top" align="right" style="padding-right: 0px;">
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
                                                {{-- @if($design->is_name) --}}

                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Mr/Ms<span style="padding-left: 30px; font-weight: bold;"><span id="isName"></span></span></td>
                                                {{-- @endif --}}


                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    School
                                                    Name<span style="padding-left: 30px; font-weight: bold;"><span id="modalSchoolName"></span></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Exam
                                                    Center<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span id="modalExamCenter"></span></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px; line-height: normal;">
                                                    this is
                                                    exam</td>
                                            </tr>

                                            <tr>
                                            <tr id="classteacherRemarks" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Class
                                                    Teacher Remarks<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span id="classteacherRemarks">
                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isName" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span> Taylor
                                                        </span></span>
                                                </td>

                                            </tr>


                                            <tr id="isFatherName" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Father
                                                    Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Harry
                                                        </span></span>
                                                </td>

                                            </tr>


                                            <tr id="isMotherName" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Mother
                                                    Name<span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Taylor
                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isPhoto" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Photo
                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>photo
                                                        </span></span>
                                                </td>

                                            </tr>


                                            <tr id="isDob" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">DOB
                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>25th April
                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isAdmissionNumber" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Admission
                                                    Number
                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>123

                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isRollNumber" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Roll
                                                    Number
                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>3

                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isAddress" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Address

                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Kathmandu

                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isGender" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Gender

                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Female

                                                        </span></span>
                                                </td>

                                            </tr>


                                            <tr id="isDivision" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Division

                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>First


                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isRank" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Rank

                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>First


                                                        </span></span>
                                                </td>

                                            </tr>


                                            <tr id="isCustomField" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Custom
                                                    Field

                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>Taylor


                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isClass" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Class


                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>2



                                                        </span></span>
                                                </td>

                                            </tr>

                                            <tr id="isSession" style="display: none;">
                                                <td valign="top" style="text-transform: uppercase; padding-bottom: 15px;">
                                                    Session


                                                    <span style="text-transform: uppercase; padding-top: 15px; font-weight: bold; padding-bottom: 20px; padding-left: 30px;"><span>2020



                                                        </span></span>
                                                </td>

                                            </tr>


                            </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" class="denifittable" style="text-align: center; text-transform: uppercase;>
                                        <tbody>
                                            <tr>
                                        <th valign=" middle" style="width:35%;">Subjects</th>
                                <th valign="middle" style="text-align: center;">Max Marks</th>
                                <th valign="middle" style="text-align: center;">Min Marks</th>
                                <th valign="top" style="text-align: center;">Marks Obtained</th>
                                <th valign="middle" style="border-right:1px solid #999; text-align: center;">
                                    Remarks</th>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: left;">Hindi [special]</td>
                        <td valign="top" style="text-align: center;">100</td>
                        <td valign="top" style="text-align: center;">33</td>
                        <td valign="top" style="text-align: center;">085</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999;">Distin</td>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: left;">English [General]</td>
                        <td valign="top" style="text-align: center;">100</td>
                        <td valign="top" style="text-align: center;">33</td>
                        <td valign="top" style="text-align: center;">051</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999"></td>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: left;">Physics</td>
                        <td valign="top" style="text-align: center;">100</td>
                        <td valign="top" style="text-align: center;">25</td>
                        <td valign="top" style="text-align: center;">066</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999"></td>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: left;">Chemistry</td>
                        <td valign="top" style="text-align: center;">100</td>
                        <td valign="top" style="text-align: center;">027</td>
                        <td valign="top" style="text-align: center;">049</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999"></td>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: left;">Mathematics</td>
                        <td valign="top" style="text-align: center;">100</td>
                        <td valign="top" style="text-align: center;">33</td>
                        <td valign="top" style="text-align: center;">033</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999"></td>
                    </tr>
                    <tr>
                        <td valign="top"></td>
                        <td valign="top" colspan="0" style="border-left:0">500</td>
                        <td valign="top" colspan="0">Grand Total</td>
                        <td valign="top" style="text-align: center;">284</td>
                        <td valign="top" style="text-align: center;border-right:1px solid #999"></td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="5" width="20%" style="font-weight: normal; text-align: left; border-right: 1px solid #999;">Grand
                            Total
                            In Words: <span style="text-align: left;font-weight: bold; padding-left: 30px;">Two
                                hundred eighty four</span></td>
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
                        {{-- <td valign="top"
                                style="text-transform: uppercase; padding-bottom: 15px; line-height: normal;">
                                thank you
                            </td> --}}

                        <td>
                            <div class="main-div-marksheet">
                                <div class="left-sign">
                                    <img src="left_sign.jpg" alt="Left Sign" id="modalLeftSign">
                                </div>
                                <div class="middle-sign">
                                    <img src="middle_sign.jpg" alt="Middle Sign" id="modalMiddleSign">
                                </div>
                                <div class="right-sign">
                                    <img src="right_sign.jpg" alt="Right Sign" id="modalRightSign">
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


<div class="card">
    <div class="card-body">
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-12">
                    <div class="report-table-container">

                        <div class="table-responsive">
                            <table id="mark_sheet_design-table" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        {{-- <th>Heading</th> --}}
                                        {{-- <th>Title</th> --}}
                                        <th>Exam Name</th>
                                        {{-- <th>School Name</th> --}}
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



{{-- <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
});
    {{--
    </script> --}}




<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#mark_sheet_design-table').DataTable({
            processing: true
            , serverSide: true
            , ajax: {
                url: '{{ route('admin.mark-sheetdesigns.get') }}'
                , type: 'post'
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                }
                // , {
                //     data: 'heading'
                //     , name: 'heading'
                // }
                // , {
                //     data: 'title'
                //     , name: 'title'
                // }
                , {
                    data: 'exam_name'
                    , name: 'exam_name'
                }
                // , {
                //     data: 'school_name'
                //     , name: 'school_name'
                // }
                , {
                    data: 'exam_center'
                    , name: 'exam_center'
                }
                , {
                    data: 'status'
                    , name: 'status'
                }
                , {
                    data: 'created_at'
                    , name: 'created_at'
                }
                , {
                    data: 'actions'
                    , name: 'actions'
                }
            ]
            , initComplete: function() {
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
