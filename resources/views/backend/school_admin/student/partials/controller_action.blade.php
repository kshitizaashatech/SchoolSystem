@can('edit_students')
<a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-outline-primary btn-sm mx-1 edit-student"
    data-toggle="tooltip" data-placement="top" title="Edit">
    <i class="fa fa-edit"></i>
</a>
@endcan

@can('delete_students')
<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
    data-bs-target="#delete{{ $student->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
    <i class="far fa-trash-alt"></i>
</button>

<div class="modal fade" id="delete{{ $student->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>Are you sure to delete <span class="must" id="underscore"> {{ $student->name }}</span> ? </p>
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

<!-- New button -->
{{-- <button type="button" class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="Add More Information">
    <i class="fas fa-plus"></i>
</button> --}}

@can('create_students_additionalinformations')
<a href="{{ route('admin.students.additionalinformations_create', ['student_id' => $student->id]) }}" class="btn btn-outline-primary btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Add More Information">
    <i class="fas fa-plus"></i>
</a>


@endcan




