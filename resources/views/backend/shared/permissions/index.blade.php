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
            @include('backend.shared.permissions.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="permission-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
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

        <div class="modal fade" id="createPermission" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="permissionsForm"  action="{{ route('admin.permissions.store') }}">
                            @csrf
                            <div class="col-md-12 col-xs-12">
                                <div class="p-2 label-input">
                                    <label>Name<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input id="createInput" type="text" name="name" class="input-text single-input-text" autofocus required  onkeyup="replaceFunction(this.value)" placeholder="Type your permission..">
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

        {{-- ===================================================================

                        EDIT MODAL

        =================================================================== --}}

        <div class="modal fade" id="editPermission" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="">
                    <form id="editPermissionsForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_method" id="methodField" >
                        <input type="hidden" name="dynamic_id" id="dynamic_id">
                        <div class="col-md-12 col-xs-12">
                            <div class="p-2 label-input">
                                <label>Name<span class="must" id="permissionName">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" name="name" class="editinput-text single-input-text" id="dynamic_name" autofocus required onkeyup="replaceFunctionTwo(this.value)">
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


        $('#permission-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.permissions.get') }}',
                type: 'post'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'permission',
                    name: 'permission'
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
        $(document).on('click', '.edit-permission', function() {
            // Get the data attributes
            var id = $(this).data('id');
            var name = $(this).data('name');

            console.log(id);
            console.log(name);

            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);


            $('#editPermissionsForm').attr('action', '{{ route('admin.permissions.update', '') }}' + '/' + id);
            
            $('#methodField').val('PUT');

            // Show the modal
            $('#editPermission').modal('show');

            // Prevent the default anchor behavior
            return false;

        });
        
        function replaceFunctionTwo(val) {
            var element = document.querySelector('.editinput-text');
            element.value = val.replace(' ', '_');

            console.log(element.value);
        }
        
        function replaceFunction(val) {
            document.getElementById('createInput').value = val.replace(' ', '_');
        }

    </script>
@endsection
@endsection
