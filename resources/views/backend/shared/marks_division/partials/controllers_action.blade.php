@can('edit_marks_divisions')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-marksdivision" data-id="{{ $marksdivision->id }}"
        data-name="{{ $marksdivision->name }}" data-points="{{ $marksdivision->points }}" data-marks_from="{{ $marksdivision->marks_from }}" data-marks_to ="{{ $marksdivision->marks_to }}" data-description="{{ $marksdivision->description }}"
        data-is_active="{{ $marksdivision->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_marks_divisions')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $marksdivision->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $marksdivision->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.marks-divisions.destroy', $marksdivision->id) }}" accept-charset="UTF-8"
                    method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore" class="must"> {{ $marksdivision->name }} </span>?</p>
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
