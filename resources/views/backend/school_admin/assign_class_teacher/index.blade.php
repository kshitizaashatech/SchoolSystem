@extends('backend.layouts.master')

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
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.assign_class_teacher.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="class-table" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Academic Session</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                {{-- <th>Class Teacher</th> --}}
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

        <div class="modal fade" id="createClass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Class Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="classForm" action="{{ route('admin.assign-classteachers.store') }}"

                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label for="academic_session_id">Academic Session</label>

                                    <select id="dynamic_academic_session_id" name="academic_session_id" data-iteration="0"
                                        class="col-md-12 academic_session_id" required>

                                        <option disabled selected value="{{ old('academic_session_id') }}">Select Academic
                                            Session
                                        </option>
                                        @foreach ($academicmanagement as $academic)
                                            <option value="{{ $academic->id }}">{{ $academic->session }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_session_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="p-2 label-input">
                                    <label for="class_id">Class</label>

                                    <select id="dynamic_class_id" name="class_id" data-iteration="0"
                                        class="col-md-12 class_id" required>

                                        <option disabled selected value="{{ old('class_id') }}">Select Class
                                        </option>
                                        @foreach ($classmanagement as $class)
                                            <option value="{{ $class->id }}">{{ $class->class }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="p-2 label-input">
                                    <label for="section_id">Section</label>

                                    <select id="dynamic_section_id" name="section_id" data-iteration="0"
                                        class="col-md-12 section_id" required>

                                        <option disabled selected value="{{ old('section_id') }}">Select Section
                                        </option>
                                        @foreach ($sectionmanagement as $section)
                                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
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
        $('#class-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.assign-classteachers.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'academic_session_id',
                    name: 'academic_session_id'
                },
                {
                    data: 'class_id',
                    name: 'class_id'
                },
                {
                    data: 'section_id',
                    name: 'section_id'
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
        $(document).on('click', '.edit-class', function() {
            // console.log('Edit button clicked!');
            var id = $(this).data('id');
            // var incomehead = $(this).data('incomehead_id');
            var academic = $(this).data('academic_session_id');
            var clazz = $(this).data('class_id');
            var section = $(this).data('section_id');
            var is_active = $(this).data('is_active');

            $('#dynamic_id').val(id);
            $('#dynamic_academic_session_id').val(academic);
            $('#dynamic_class_id').val(clazz);
            $('#dynamic_section_id').val(section);
            // $('#dynamic_document').val(document);
            // $('#dynamic_description').val(description);
            // var fileInput = $('#dynamic_document');
            // fileInput.replaceWith(fileInput.val('').clone(true));

            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // $('#incomeForm').attr('action', '{{ route('admin.incomes.update', '') }}' + '/' +
            //     id);
            $('#classForm').attr('action', '{{ route('admin.assign-classteachers.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            $('#createClass').modal('show');

            return false;
        });
    </script>
@endsection
@endsection
