@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">

            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}
                </h2>
            </div>
            @include('backend.shared.inclusivequotas.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="inclusive-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Priority</th>
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

        <div class="modal fade" id="createInclusive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Inclusive Quotas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="inclusiveForm" action="{{ route('admin.inclusive-quotas.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label>Name<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('name') }}" name="name"
                                            class="input-text single-input-text" id="dynamic_name" autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Description<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('description') }}" name="description"
                                            class="input-text single-input-text" id="dynamic_description" autofocus
                                            required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Priority<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('priority') }}" name="priority"
                                            class="input-text single-input-text" id="dynamic_priority" autofocus required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="col-sm-10 p-2">
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

                                <div class="border-top col-md-12 d-flex justify-content-end p-2">
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


        $('#inclusive-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.inclusive-quotas.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'priority',
                    name: 'priority'
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

        //edit funcion
        $(document).on('click', '.edit-inclusive', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var priority = $(this).data('priority');
            var is_active = $(this).data('is_active');
            console.log(id);
            console.log(name);
            console.log(description);
            console.log(priority);
            console.log(is_active);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);
            $('#dynamic_description').val(description);
            $('#dynamic_priority').val(priority);

            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false); // Uncheck all radio buttons
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked',
                true); // Check the correct radio button

            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#inclusiveForm').attr('action', '{{ route('admin.inclusive-quotas.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createInclusive').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
