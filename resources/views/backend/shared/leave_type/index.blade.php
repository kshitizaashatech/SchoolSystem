@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.leave_type.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="leave-type-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Type</th>
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

        <div class="modal fade" id="createLeaveType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="leaveTypeForm" action="{{ route('admin.leave-types.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label>Type<span class="must"> *</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('type') }}" name="type"
                                            class="input-text single-input-text" id="dynamic_type" autofocus required>
                                    </div>
                                </div>


                                <div class="p-2 label-input">
                                    <label>Status<span class="must"> *</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_active" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_active" id="option2"
                                                value="0" autocomplete="off" />
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
        </div>
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#leave-type-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.leave-types.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },

                {
                    data: 'type',
                    name: 'type'
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

        // edit function
        $(document).on('click', '.edit-leave-type', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var is_active = $(this).data('is_active');


            // Set values in the modal form
            $('#dynamic_id').val(id);

            $('#dynamic_type').val(type);

            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // If the form has an ID input field
            $('#leaveTypeForm').attr('action', '{{ route('admin.leave-types.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createLeaveType').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
