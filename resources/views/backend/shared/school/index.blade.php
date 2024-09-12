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
            @include('backend.shared.school.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="school-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Address</th>
                                                {{-- <th>District</th> --}}

                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Status</th>
                                                {{-- <th>School Group</th> --}}
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

        {{-- <div class="modal fade" id="createDesignation" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <form method="post" id="designationForm" action="{{ route('admin.designations.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">
                        <input type="hidden" name="dynamic_id" id="dynamic_id">
                        <div class="col-md-12 d-flex flex-wrap gap-5">
                            <div class="form-group col-md-4 col-xs-12">
                                <label>Name<span class="must">*</span></label>

                                <div class="col-sm-10">
                                    <input type="text" value="{{ old('name') }}" name="name" class="input-text"
                                        id="dynamic_name" autofocus required>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-xs-12">
                                <label>Status<span class="must">*</span></label>
                                <div class="col-sm-10">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_active" id="option1" value="1"
                                            autocomplete="off" checked />
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_active" id="option2" value="0"
                                            autocomplete="off" />
                                        <label class="btn btn-secondary" for="option2">Inactive</label>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#school-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.schools.get') }}',
                type: 'post'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                // {
                //     data: 'district_name',
                //     name: 'district_name'
                // },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'status',
                    name: 'status'
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

        //edit funcion
        $(document).on('click', '.edit-designation', function() {
            // Get the data attributes
            var id = $(this).data('id');
            // var name = $(this).data('name');
            var is_active = $(this).data('is_active');
            console.log(id);
            console.log(name);
            console.log(is_active);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);

            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false); // Uncheck all radio buttons
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked',
                true); // Check the correct radio button

            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#designationForm').attr('action', '{{ route('admin.designations.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createDesignation').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
