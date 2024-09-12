@can('edit_primary_lessonmarks')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-primarymarks" data-id="{{ $primaryMarks['id'] }}"
        data-class_id="{{ $primaryMarks['class_id'] }}" data-section_id="{{ $primaryMarks['section_id'] }}"
        data-subject_group_id="{{ $primaryMarks['subject_group_id'] }}" data-subject_id="{{ $primaryMarks['subject_id'] }}"
        data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

<!-- Delete button and modal -->
@can('delete_primary_lessonmarks')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $primaryMarks['id'] }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $primaryMarks['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.primary-lessonmarks.destroy', $primaryMarks['id']) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete entire Lesson?</p>
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
