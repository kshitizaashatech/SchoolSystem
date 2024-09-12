@can('edit_departments')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-department" data-id="{{ $department->id }}"
        data-name="{{ $department->name }}" data-is_active="{{ $department->is_active }}" data-toggle="tooltip"
        data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_departments')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $department->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $department->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('admin.departments.destroy', $department->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">

                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">

                        <p>Are you sure to delete <span class="must" id="underscore"> {{ $department->name }} </span>?
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
