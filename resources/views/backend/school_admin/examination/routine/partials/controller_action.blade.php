@can('edit_exam_routines')
    <a href="{{ route('admin.exam-routines.edit', $routine->id) }}" class="btn btn-outline-primary btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan
{{-- @can('delete_exam_routines')
    <a href="{{ route('admin.exam-routines.destroy', $routine->id) }}" class="btn btn-outline-danger btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="fa fa-edit"></i>
    </a>
@endcan --}}

<!-- Delete button and modal -->
@can('delete_exam_routines')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $routine->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $routine->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.exam-routines.destroy', $routine->id) }}"
                    accept-charset="UTF-8" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore" class="must"> </span>?
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

{{-- @can('create_assign_students')
    <a href="{{ route('admin.assign-students.create', $examinations->id) }}" class="btn btn-outline-success btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Assign Students">
        <i class="fas fa-arrow-circle-right"></i>
    </a>
@endcan --}}


@can('create_assign_students')
    <a href="{{ route('admin.assign-students.create.for-examroutine', ['exam_id' => $examinations->id, 'routine_id' => $routine->id]) }}"
        class="btn btn-outline-success btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Assign Students">
        <i class="fas fa-arrow-circle-right"></i>
    </a>
@endcan



@can('create_exam_results')
    <a href="{{ route('admin.exam-results.create.for-examroutine', ['exam_id' => $examinations->id, 'routine_id' => $routine->id]) }}"
        class="btn btn-outline-success btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Exam Results">
        <i class="fas fa-arrow-circle-right"></i>
    </a>
@endcan
