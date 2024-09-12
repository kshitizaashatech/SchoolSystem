@can('edit_student_leaverequests')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 studentLeave" data-id="{{ $studentLeave->id }}"
        data-school_id="{{ $studentLeave->school_id }}" data-from_date="{{ $studentLeave->from_date }}"
        data-class_id="{{ $studentLeave->class_id }}" data-section_id="{{ $studentLeave->section_id }}"
        data-student_id="{{ $studentLeave->student_id }}" data-to_date="{{ $studentLeave->to_date }}"
        data-docs="{{ $studentLeave->docs }}" data-reason="{{ $studentLeave->reason }}"
        data-approved_by="{{ $studentLeave->approved_by }}" data-approved_date="{{ $studentLeave->approved_date }}"
        data-remarks="{{ $studentLeave->remarks }}" data-request_type="{{ $studentLeave->request_type }}"
        data-status="{{ $studentLeave->status }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_student_leaverequests')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $studentLeave->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $studentLeave->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.student-leaverequests.destroy', $studentLeave->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore"> {{ $studentLeave->user->f_name }}'s Leave</span>
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
