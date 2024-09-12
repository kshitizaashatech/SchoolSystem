@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.shared.marks_division.partials.action')
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">

                            <div class="table-responsive">
                                <table id="marksdivision-table"
                                    class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Points</th>
                                            <th>Marks From</th>
                                            <th>Marks To</th>
                                            <th>Description</th>
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

    <div class="modal fade" id="createMarksDivision" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Marks Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="">

                    <form method="post" id="MarksDivisionForm" action="{{ route('admin.marks-divisions.store') }} ">
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
                                <label>Points<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('points') }}" name="points"
                                        class="input-text single-input-text" id="dynamic_points" autofocus required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Marks From<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('marks_from') }}" name="marks_from"
                                        class="input-text single-input-text" id="dynamic_marks_from" autofocus required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Marks To<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('marks_to') }}" name="marks_to"
                                        class="input-text single-input-text" id="dynamic_marks_to" autofocus required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Description<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <textarea name="description" class="input-text single-input-text"
                                        id="dynamic_description" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Status<span class="must">*</span></label>
                                <div class="single-input-modal">
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
        $('#marksdivision-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.marks-divisions.get') }}',
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
                    data: 'points',
                    name: 'points'
                },
                {
                    data: 'marks_from',
                    name: 'marks_from'
                },
                {
                    data: 'marks_to',
                    name: 'marks_to'
                },
                {
                    data: 'description',
                    name: 'description'
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
        $(document).on('click', '.edit-marksdivision', function() {
            // Get the data attributes
            var id = $(this).data('id');
            // var school_id = $(this).data('school_id');
            var name = $(this).data('name');
            var points = $(this).data('points');
            var marks_from = $(this).data('marks_from');
            var marks_to = $(this).data('marks_to');
            var description = $(this).data('description');
            var is_active = $(this).data('is_active');
            console.log(name);
            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_name').val(name);
            $('#dynamic_points').val(points);
            $('#dynamic_marks_from').val(marks_from);
            $('#dynamic_marks_to').val(marks_to);
            $('#dynamic_description').val(description);
            // console.log(dynamic_name);

            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false); // Uncheck all radio buttons
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked',
                true); // Check the correct radio button

            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#MarksDivisionForm').attr('action', '{{ route('admin.marks-divisions.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createMarksDivision').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
</script>
@endsection
@endsection