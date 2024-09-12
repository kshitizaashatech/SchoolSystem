@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.subject.partials.action')
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">

                            <div class="table-responsive">
                                <table id="subject-table" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            {{-- <th>School ID</th> --}}
                                            <th>Subject Code</th>
                                            <th>Subject</th>
                                            <th>Credit Hour</th>
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

    <div class="modal fade" id="createSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="">
                    <form method="post" id="subjectForm" action="{{ route('admin.subjects.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">
                        <input type="hidden" name="dynamic_id" id="dynamic_id">
                        <div class="col-md-12">
                            <div class="p-2 label-input">
                                <label>Subject Code<span class="must"> *</span></label>

                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('subject_code') }}" name="subject_code" class="input-text single-input-text" id="dynamic_subject_code" autofocus required>
                                </div>
                            </div>

                            <div class="p-2 label-input">
                                <label>Subject<span class="must"> *</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('subject') }}" name="subject" class="single-input-text" id="dynamic_subject" autofocus required>
                                </div>
                            </div>

                            <div class="p-2 label-input">
                                <label>Credit Hour<span class="must"> *</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('credit_hour') }}" name="credit_hour" class="single-input-text" id="dynamic_credit_hour" autofocus required>
                                </div>
                            </div>

                            <div class="p-2 mt-2">
                                <label>Status<span class="must"> *</span></label>
                                <div class="col-sm-10">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_active" id="option1" value="1" autocomplete="off" checked />
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_active" id="option2" value="0" autocomplete="off" />
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

    $('#subject-table').DataTable({
        processing: true,
        serverSide: true,
         ajax: {
            url: '{{ route('admin.subjects.get') }}',
             type: 'POST'
        },
         columns: [{
                data: 'id',
                 name: 'id'
            },
            // {
            //     data: 'school_id',
            //     name: 'school_id'
            // },
            {
                data: 'subject_code',
                name: 'subject_code'
            },
            {
                data: 'subject',
                name: 'subject'
            },
            {
                data: 'credit_hour',
                name: 'credit_hour'
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

    $(document).on('click', '.edit-subject', function() {
        var id = $(this).data('id');
        // var school_id = $(this).data('school_id');
        var subject_code = $(this).data('subject_code');
        var subject = $(this).data('subject');
        var credit_hour = $(this).data('credit_hour');
        var is_active = $(this).data('is_active');

        $('#dynamic_id').val(id);
        // $('#dynamic_school_id').val(school_id);
        $('#dynamic_subject_code').val(subject_code);
        $('#dynamic_subject').val(subject);
        $('#dynamic_credit_hour').val(credit_hour);

        $('input[name="is_active"]').prop('checked', false);
        $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

        $('#subjectForm').attr('action', '{{ route('admin.subjects.update', '') }}' + '/' + id);
        $('#methodField').val('PUT');

        $('#createSubject').modal('show');

        return false;
    });

</script>
@endsection
@endsection
