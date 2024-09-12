@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.extraactivities.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="eca-activities-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Player Type</th>
                                                <th>Status</th>
                                                <th>ECA Head</th>
                                                {{-- <th>Created At</th> --}}
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

        <div class="modal fade" id="createEcaActivity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add ECA Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="ecaActivityForm" action="{{ route('admin.eca_activities.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 input-label">
                                    <label>ECA Head<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <select name="eca_head_id" class="input-text single-input-text" id="dynamic_eca_head_id" required>
                                            @foreach($ecaHeads as $head)
                                                <option value="{{ $head->id }}">{{ $head->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 input-label">
                                    <label>Title<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('title') }}" name="title"
                                            class="input-text single-input-text" id="dynamic_title" autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Description<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <textarea name="description" class="input-text single-input-text" id="dynamic_description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 input-label">
                                    <label>PDF/Image</label>
                                    <div class="single-input-modal">
                                        <input type="file" name="pdf_image" class="input-text single-input-text" id="dynamic_pdf_image">
                                    </div>
                                </div>
                                <div class="p-2 input-label">
                                    <label>Player Type<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <select name="player_type" class="input-text single-input-text" id="dynamic_player_type" required>
                                            <option value="single">Single Player</option>
                                            <option value="multi">Multi Player</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 input-label">
                                    <label>Select Schools<span class="must">*</span></label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="select_all_schools">
                                        <label class="form-check-label" for="select_all_schools">Select All Schools</label>
                                    </div>
                                    <div class="single-input-modal">
                                        <select name="school_ids[]" class="input-text single-input-text" id="dynamic_school_ids" multiple required>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 input-label">
                                    <label>Status<span class="must">*</span></label>
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
        $('#eca-activities-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.eca_activities.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'player_type',
                    name: 'player_type'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'eca_head.name',
                    name: 'eca_head.name'
                },
                // {
                //     data: 'created_at',
                //     name: 'created_at'
                // },
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

        $(document).on('click', '.edit-eca-activity', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var player_type = $(this).data('player_type');
            var is_active = $(this).data('is_active');
            var eca_head_id = $(this).data('eca_head_id');

            $('#dynamic_id').val(id);
            $('#dynamic_title').val(title);
            $('#dynamic_description').val(description);
            $('#dynamic_player_type').val(player_type);
            $('#dynamic_eca_head_id').val(eca_head_id);

            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            $('#ecaActivityForm').attr('action', '{{ route('admin.eca_activities.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            $('#createEcaActivity').modal('show');

            return false;
        });

        $('#select_all_schools').change(function() {
            if ($(this).is(':checked')) {
                $('#dynamic_school_ids option').prop('selected', true);
                $('#dynamic_school_ids').trigger('change');
            } else {
                $('#dynamic_school_ids option').prop('selected', false);
                $('#dynamic_school_ids').trigger('change');
            }
        });
    </script>
@endsection
@endsection
