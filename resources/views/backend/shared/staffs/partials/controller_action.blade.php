@can('edit_staffs')
<a href="{{ route('admin.staffs.edit', $staff->id) }}" class="btn btn-outline-primary btn-sm mx-1 edit-staff"
    data-id="{{ $staff->id }}" data-toggle="tooltip" data-placement="top" title="Edit">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can('delete_staffs')
<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
    data-bs-target="#delete{{ $staff->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
    <i class="far fa-trash-alt"></i>
</button>
<div class="modal fade" id="delete{{ $staff->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.staffs.destroy', $staff->id) }}">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>Are you sure to delete <span id="underscore" class="must">{{ $staff->name }}</span>?</p>
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
@can('create_staffs_leavedetails')
<a href="{{ route('admin.staffs.leavedetails', ['type' => 'leave', 'staff_id' => $staff->id]) }}" class="btn btn-outline-success btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Add Leave Details">
    <i class="fas fa-user-plus"></i>
</a>
@endcan
@can('create_staffs_resignation_details')
<a href="{{ route('admin.staffs.resignationdetails', ['type' => 'resignation', 'staff_id' => $staff->id]) }}" class="btn btn-outline-warning btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Add Resignation Details">
    <i class="fas fa-user-plus"></i>
</a>
@endcan






