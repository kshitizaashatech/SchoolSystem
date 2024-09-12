@can('edit_marks_grades')
<a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-marksgrade" data-id="{{ $marksgrade->id }}" data-grade_name="{{ $marksgrade->grade_name }}" data-grade_points="{{ $marksgrade->grade_points }}" data-percentage_from="{{ $marksgrade->percentage_from }}" data-percentage_to="{{ $marksgrade->percentage_to }}" data-achievement_description="{{ $marksgrade->achievement_description }}" data-is_active="{{ $marksgrade->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
    <i class="fa fa-edit"></i>
</a>
@endcan

@can('delete_marks_grades')
<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $marksgrade->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
    <i class="far fa-trash-alt"></i>
</button>
<div class="modal fade" id="delete{{ $marksgrade->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.marks-grades.destroy', $marksgrade->id) }}" accept-charset="UTF-8" method="POST">
                <div class="modal-body">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <p>Are you sure to delete <span id="underscore" class="must"> {{ $marksgrade->name }} </span>?</p>
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
