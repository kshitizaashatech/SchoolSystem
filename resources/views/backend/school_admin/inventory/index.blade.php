@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                {{-- <h2>{{ $page_title }}</h2> --}}
            </div>
            @include('backend.school_admin.inventory.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="inventory-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Inventory Head</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Description</th>
                                                <th>Created At</th>
                                                <th>Status</th>
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

        <div class="modal fade" id="createInventory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="inventoryForm" action="{{ route('admin.inventories.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label for="inventoryhead_id">Inventory Head</label>
                                    <div class="select">

                                        <select id="dynamic_inventoryhead_id_id" name="inventory_head_id" data-iteration="0"
                                            class="inventoryhead_id_id" required>
                                            <option disabled selected value="{{ old('inventory_head_id') }}">Select Inventory Head
                                            </option>
                                            @foreach ($inventorieshead as $inventory)
                                                <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('inventoryhead_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="p-2 label-input">
                                    <label>Title<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('name') }}" name="name"
                                            class="input-text single-input-text" id="dynamic_name" autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Unit<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('unit') }}" name="unit"
                                            class="input-text single-input-text" id="dynamic_unit" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Description<span class="must"> *</span></label>
                                    <div class="single-input-modal">
                                        <textarea name="description" class="input-text single-input-text" id="dynamic_description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Status<span class="must"> *</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="status" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="status" id="option2"
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
        $('#inventory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.inventories.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'inventory_head_id',
                    name: 'inventory_head_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
        $(document).on('click', '.edit-inventory', function() {
            console.log('Edit button clicked!');
            var id = $(this).data('id');
            // var incomehead = $(this).data('incomehead_id');
            var name = $(this).data('name');
            var unit = $(this).data('unit');
            var description = $(this).data('description');
            var status = $(this).data('status');

            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);
            $('#dynamic_unit').val(unit);
            $('#dynamic_description').val(description);
            // $('#dynamic_document').val(document);
            // $('#dynamic_description').val(description);
            // fileInput.replaceWith(fileInput.val('').clone(true));

            $('input[name="status"]').prop('checked', false);
            $('input[name="status"][value="' + status + '"]').prop('checked', true);          
            $('#inventoryForm').attr('action', '{{ route('admin.inventories.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            $('#createInventory').modal('show');

            return false;
        });
    </script>
@endsection
@endsection
