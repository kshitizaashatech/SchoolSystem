@extends('backend.layouts.master')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.shared.marks_grade.partials.action')
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">

                            <div class="table-responsive">
                                <table id="marksgrade-table"
                                    class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Grade Name</th>
                                            <th>Grade Points</th>
                                            <th>Percentage From</th>
                                            <th>Percentage To</th>
                                            <th>Achievement Description</th>
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

    <div class="modal fade" id="createMarksGrade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Marks Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="">

                    <form method="post" id="MarksGradeForm" action="{{ route('admin.marks-grades.store') }} ">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">
                        <input type="hidden" name="dynamic_id" id="dynamic_id">

                        <div class="col-md-12">
                            <div class="p-2 label-input">
                                <label>Grade Name<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('grade_name') }}" name="grade_name"
                                        class="input-text single-input-text" id="dynamic_grade_name" autofocus required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Grade Points<span class="must"> *</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('grade_points') }}" name="grade_points"
                                        class="input-text single-input-text" id="dynamic_grade_points" autofocus
                                        required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Percentage From<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('percentage_from') }}" name="percentage_from"
                                        class="input-text single-input-text" id="dynamic_percentage_from" autofocus
                                        required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Percentage To<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <input type="text" value="{{ old('percentage_to') }}" name="percentage_to"
                                        class="input-text single-input-text" id="dynamic_percentage_to" autofocus
                                        required>
                                </div>
                            </div>
                            <div class="p-2 label-input">
                                <label>Achievement Description<span class="must">*</span></label>
                                <div class="single-input-modal">
                                    <textarea class="single-input-text" name="achievement_description"
                                        id="dynamic_achievement_description" cols="30" rows="10"
                                        value="{{ old('achievement_description') }}" required>
                                        </textarea>
                                </div>
                            </div>
                            <div class="p-2 label-input">
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
        $('#marksgrade-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.marks-grades.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'grade_name',
                    name: 'grade_name'
                },
                {
                    data: 'grade_points',
                    name: 'grade_points'
                },
                {
                    data: 'percentage_from',
                    name: 'percentage_from'
                },
                {
                    data: 'percentage_to',
                    name: 'percentage_to'
                },
                {
                    data: 'achievement_description',
                    name: 'achievement_description'
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
        $(document).on('click', '.edit-marksgrade', function() {
            // Get the data attributes
            var id = $(this).data('id');
            // var school_id = $(this).data('school_id');
            var grade_name = $(this).data('grade_name');
            var grade_points = $(this).data('grade_points');
            var percentage_from = $(this).data('percentage_from');
            var percentage_to = $(this).data('percentage_to');
            var achievement_description = $(this).data('achievement_description');
            var is_active = $(this).data('is_active');
            // console.log(grade_name);
            // Set values in the modal form
            $('#dynamic_id').val(id);
            $('#dynamic_grade_name').val(grade_name);
            $('#dynamic_grade_points').val(grade_points);
            $('#dynamic_percentage_from').val(percentage_from);
            $('#dynamic_percentage_to').val(percentage_to);
            $('#dynamic_achievement_description').val(achievement_description);
            console.log(dynamic_grade_name);
            // Check the corresponding radio button
            $('input[name="is_active"]').prop('checked', false); // Uncheck all radio buttons
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked',
                true); // Check the correct radio button

            // If the form has an ID input field
            // $('#designationForm').attr('action', 'route('admin.designations.update', '+ id +')');
            $('#MarksGradeForm').attr('action', '{{ route('admin.marks-grades.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            // Show the modal
            $('#createMarksGrade').modal('show');

            // Prevent the default anchor behavior
            return false;
        });


</script>
@endsection
@endsection
