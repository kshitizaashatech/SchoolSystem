@can('edit_examinations')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-examination" data-id="{{ $examination->id }}"
        data-exam="{{ $examination->exam }}"
        data-final_term_examination="{{ isset($examination->finalTerminalExaminations) ? $examination->finalTerminalExaminations : '' }}"
        data-exam_type="{{ $examination->exam_type }}" data-is_publish="{{ $examination->is_publish }}"
        data-is_rank_generated="{{ $examination->is_rank_generated }}" data-description="{{ $examination->description }}"
        data-is_active="{{ $examination->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

<!-- Delete button and modal -->
@can('delete_examinations')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $examination->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $examination->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.examinations.destroy', $examination->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore" class="must"> {{ $examination->exam }} </span>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan

{{-- PRINT MARKSHEET BUTTON --}}
{{-- <a href="{{ route('admin.generate.marksheets.create', ['examination_id' => $examination->id]) }}"
    class="btn btn-outline-secondary btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Print Marksheet">
    <i class="fas fa-print"></i>
</a> --}}


@can('create_exam_routines')
    <a href="{{ route('admin.exam-routines.create', $examination->id) }}" class="btn btn-outline-danger btn-sm"
        data-toggle="tooltip" data-placement="top" title="Exam Routines">
        <i class="fas fa-calendar-check"></i>
    </a>
@endcan

{{-- @can('create_assign_students')
    <a href="{{ route('admin.assign-students.create', $examination->id) }}" class="btn btn-outline-dark btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Assign Students">
        <i class="fas fa-link"></i>
    </a>
@endcan --}}

@can('create_assign_teachers')

    <a href="{{ route('admin.assign-teachers.create', $examination->id) }}" class="btn btn-outline-dark btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Assign Teachers">
        <i class="fas fa-link"></i>
    </a>
@endcan
@can('create_exam_results')
    <a href="{{ route('admin.exam-results.assignmarks', $examination->id) }}" class="btn btn-outline-success btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Exam Results">
        <i class="fas fa-check"></i>
    </a>
@endcan
@can('create_generate_results')
    <a href="{{ route('admin.generate-results.create', $examination->id) }}" class="btn btn-outline-warning btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Generate Results">
        <i class="fas fa-hourglass-half"></i>
    </a>
@endcan
