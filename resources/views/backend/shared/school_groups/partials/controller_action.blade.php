{{-- @can('create_head_schoolusers')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 open-schools-modal" data-id="{{ $school_group->id }}"
        data-name="{{ $school_group->name }}" data-toggle="tooltip" data-placement="top" title="Assign Head School">
        <i class="fa fa-circle"></i>
    </a>
@endcan --}}

@can('edit_school_groups')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-schoolgroup" data-id="{{ $school_group->id }}"
        data-name="{{ $school_group->name }}" data-schools="{{ json_encode($associated_schools) }}"
        data-head-school="{{ $head_school }}" data-head-school-name="{{ $head_school_name }}" data-toggle="tooltip"
        data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan



@can('delete_school_groups')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $school_group->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>
    <div class="modal fade" id="delete{{ $school_group->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('admin.school-groups.destroy', $school_group->id) }}"
                    accept-charset="UTF-8" method="POST">
                    <div class="modal-body">

                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">

                        <p>Are you sure to delete <span class="must" id="underscore"> {{ $school_group->name }}
                            </span>?
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
