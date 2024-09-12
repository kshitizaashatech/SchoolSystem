@can('edit_staff_leaverequests')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-leave-type" data-id="{{ $staffLeave->id }}"
        data-leave_type_id="{{ $staffLeave->leave_type_id }}" data-student_session_id="{{ $staffLeave->student_session_id }}"
        data-staff_id="{{ $staffLeave->staff_id }}" data-school_id="{{ $staffLeave->school_id }}"
        data-from_date="{{ $staffLeave->from_date }}" data-to_date="{{ $staffLeave->to_date }}"
        data-docs="{{ $staffLeave->docs }}" data-reason="{{ $staffLeave->reason }}"
        data-approved_by="{{ $staffLeave->approved_by }}" data-approved_date="{{ $staffLeave->approved_date }}"
        data-remarks="{{ $staffLeave->remarks }}" data-request_type="{{ $staffLeave->request_type }}"
        data-status="{{ $staffLeave->status }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_staff_leaverequests')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $staffLeave->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $staffLeave->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.student-leaverequests.destroy', $staffLeave->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore"> {{ $staffLeave->user->f_name }}'s Leave</span>
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
