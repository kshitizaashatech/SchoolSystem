@can('edit_student_attendances')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-attendance-type" data-id="{{ $studentAttendance->id }}"
        data-student_session_id="{{ $studentAttendance->student_session_id }}"
        data-staff_id="{{ $studentAttendance->staff_id }}" data-school_id="{{ $studentAttendance->school_id }}"
        data-biometric_attendance="{{ $studentAttendance->biometric_attendance }}" {{-- data-attendance_type_id="{{ $studentAttendance->attendance_type_id }}" --}}
        data-date="{{ $studentAttendance->date }}" data-remarks="{{ $studentAttendance->remarks }}"
        data-is_active="{{ $studentAttendance->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_student_attendances')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $studentAttendance->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $studentAttendance->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.student-attendances.destroy', $studentAttendance->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore"> {{ $studentAttendance->attendance_type_id }}
                            </span>
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
