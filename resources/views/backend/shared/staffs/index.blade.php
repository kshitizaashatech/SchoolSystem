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
            @include('backend.shared.staffs.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="staff-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                {{-- <th>Maritial Status</th> --}}
                                                <th>Date Of Joining</th>
                                                {{-- <th>Date of leaving</th> --}}
                                                {{-- <th>Payscale</th> --}}
                                                {{-- <th>Basic Salary</th> --}}
                                                <th>Contract Type</th>
                                                <th>Shift</th>
                                                {{-- <th>Location</th> --}}
                                                {{-- <th>Resume</th> --}}
                                                {{-- <th>Joining Letter</th> --}}
                                                {{-- <th>Resignation Letter</th> --}}
                                                {{-- <th>Medical Leave</th> --}}
                                                {{-- <th>Casual Leave</th> --}}
                                                {{-- <th>Maternity Leave</th> --}}
                                                <th>Other Document</th>
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


    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#staff-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.staffs.get') }}',
                    type: 'post'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'f_name',
                        name: 'f_name'
                    },
                    {
                        data: 'l_name',
                        name: 'l_name'
                    },
                    // {
                    //     data: 'marital_status',
                    //     name: 'marital_status'
                    // }, 
                    {
                        data: 'date_of_joining',
                        name: 'date_of_joining'
                    },
                    // {
                    //     data: 'date_of_leaving',
                    //     name: 'date_of_leaving'
                    // },
                    //  {
                    //     data: 'payscale',
                    //     name: 'payscale'
                    // }, {
                    //     data: 'basic_salary',
                    //     name: 'basic_salary'
                    // },
                    {
                        data: 'contract_type',
                        name: 'contract_type'
                    },
                    {
                        data: 'shift',
                        name: 'shift'
                    },
                    // {
                    //     data: 'location',
                    //     name: 'location'
                    // },
                    // {
                    //     data: 'resume',
                    //     name: 'resume'
                    // },
                    // {
                    //     data: 'joining_letter',
                    //     name: 'joining_letter'
                    // },
                    // {
                    //     data: 'resignation_letter',
                    //     name: 'resignation_letter'
                    // },
                    // {
                    //     data: 'medical_leave',
                    //     name: 'medical_leave'
                    // },
                    // {
                    //     data: 'casual_leave',
                    //     name: 'casual_leave'
                    // },
                    // {
                    //     data: 'maternity_leave',
                    //     name: 'maternity_leave'
                    // },
                    {
                        data: 'other_document',
                        name: 'other_document'
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
    {{-- <script>
    $(document).ready(function() {
            // Existing DataTable and other initializations...

            // Attach the click event handler to .edit-staff elements
            $('.edit-staff').on('click', function() {
                var staffId = $(this).data('id');
                window.location.href = '/admin/staffs/' + staffId + '/edit';
            });
        });
</script> --}}
@endsection
@endsection
