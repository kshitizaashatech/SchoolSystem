@can('edit_class_timetables')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-class-time" data-id="{{ $classtimetab->id }}"
        data-day="{{ $classtimetab->day }}" data-time_from="{{ $classtimetab->time_from }}"
        data-time_to="{{ $classtimetab->time_to }}" data-start_time="{{ $classtimetab->start_time }}"
        data-end_time="{{ $classtimetab->end_time }}" data-room_no="{{ $classtimetab->room_no }}"
        data-is_active="{{ $classtimetab->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_class_timetables')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $classtimetab->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $classtimetab->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.class-timetables.destroy', $classtimetab->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete Class Time with ID: <span id="underscore">{{ $classtimetab->id }}</span>
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
