@extends('backend.layouts.master')

@section('content')

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.primary_examination.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="examination-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                {{-- <th>School ID</th> --}}
                                                <th>Exam</th>

                                                <th>Publish</th>
                                                <th>Rank Generated</th>
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

        <div class="modal fade" id="createExamination" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="examinationForm" action="{{ route('admin.primary-examinations.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">

                            <div class="col-md-12">

                                <div class="p-2 label-input">
                                    <label>Exam<span class="must">*</span></label>

                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('exam') }}" name="exam"
                                            class="input-text single-input-text" id="dynamic_exam" autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Publish<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_publish" id="option1_publish"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1_publish">Active</label>

                                            <input type="radio" class="btn-check" name="is_publish" id="option2_publish"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2_publish">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Rank<span class="must">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_rank_generated"
                                                id="option1_rank" value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1_rank">Active</label>

                                            <input type="radio" class="btn-check" name="is_rank_generated"
                                                id="option2_rank" value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2_rank">Inactive</label>
                                        </div>
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
        $('#examination-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.primaryexaminations.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'exam',
                    name: 'exam'
                },
                {
                    data: 'is_publish',
                    name: 'is_publish'
                },
                {
                    data: 'is_rank_generated',
                    name: 'is_rank_generated'
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
        $(document).on('click', '.edit-examination', function() {
            // Get the data attributes
            var id = $(this).data('id');
            // var school_id = $(this).data('school_id');
            var exam = $(this).data('exam');
            // var exam_type = $(this).data('exam_type');
            var is_publish = $(this).data('is_publish');
            var is_rank_generated = $(this).data('is_rank_generated');
            var description = $(this).data('description');
            var is_active = $(this).data('is_active');

            // Set values in the modal form
            $('#dynamic_id').val(id);
            // $('#dynamic_school_id').val(school_id);
            $('#dynamic_exam').val(exam);
            // $('#exam_type').val(exam_type);
            $('#dynamic_description').val(description);


            // Check the corresponding radio button for is_active
            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // Check the corresponding radio button for is_publish
            $('input[name="is_publish"]').prop('checked', false);
            $('input[name="is_publish"][value="' + is_publish + '"]').prop('checked', true);

            // Check the corresponding radio button for is_rank_generated
            $('input[name="is_rank_generated"]').prop('checked', false);
            $('input[name="is_rank_generated"][value="' + is_rank_generated + '"]').prop('checked', true);


            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#examinationForm').attr('action', '{{ route('admin.primary-examinations.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createExamination').modal('show');

            // Prevent the default anchor behavior
            return false;
        });
    </script>
@endsection
@endsection
