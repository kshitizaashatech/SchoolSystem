@can('edit_assign_teachers')
    <a href="{{ route('admin.assign-teachers.edit', ['id' => $examinationTeachers->id]) }}" class="btn btn-outline-primary btn-sm mx-1 edit-examinationteachers" data-id="{{ $examinationTeachers->id }}"
       data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

<!-- Delete button and modal -->
@can('delete_assign_teachers')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $examinationTeachers->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $examinationTeachers->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('admin.assign-teachers', $examinationTeachers->id) }}">
                    @csrf

                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore" class="must"> {{ $examinationTeachers->exam }} </span>?
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
