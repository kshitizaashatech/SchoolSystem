@can('edit_topics')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-topic" data-id="{{ $topic['id'] }}"
        data-class_id="{{ $topic['class_id'] }}" data-section_id="{{ $topic['section_id'] }}"
        data-subject_group_id="{{ $topic['subject_group_id'] }}" data-subject_id="{{ $topic['subject_id'] }}"
        data-lesson_id="{{ $topic['lesson_id'] }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

<!-- Delete button and modal -->
@can('delete_topics')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $topic['id'] }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $topic['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.topics.destroy', $topic['id']) }}" accept-charset="UTF-8"
                    method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete entire Topic associated to Lesson ({{ $topic['lessons'] }})?</p>
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
