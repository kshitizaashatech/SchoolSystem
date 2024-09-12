@can('edit_primary_examinations')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-examination" data-id="{{ $examination->id }}"
        data-exam="{{ $examination->exam }}" data-is_publish="{{ $examination->is_publish }}"
        data-is_rank_generated="{{ $examination->is_rank_generated }}" data-description="{{ $examination->description }}"
        data-is_active="{{ $examination->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

<!-- Delete button and modal -->
@can('delete_primary_examinations')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $examination->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $examination->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.primary-examinations.destroy', $examination->id) }}"
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

@can('create_primaryexam_routines')
    <a href="{{ route('admin.primaryexam-routines.create', $examination->id) }}" class="btn btn-outline-danger btn-sm"
        data-toggle="tooltip" data-placement="top" title="Exam Routines">
        <i class="fas fa-calendar-check"></i>
    </a>
@endcan

@can('create_assign_primarystudents')
    <a href="{{ route('admin.assign-primarystudents.create', $examination->id) }}" class="btn btn-outline-dark btn-sm mx-1"
        data-toggle="tooltip" data-placement="top" title="Assign Students">
        <i class="fas fa-link"></i>
    </a>
@endcan
