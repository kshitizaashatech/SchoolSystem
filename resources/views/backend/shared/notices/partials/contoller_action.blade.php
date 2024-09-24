<div>
    <a href="{{ url()->previous() }}">
        <button class="btn-primary btn-sm">
            <i class="fa fa-angle-double-left"></i> Back
        </button>
    </a>

    @can('list_notice_head')
        <a href="{{ route('admin.notices.index') }}">
            <button class="btn-info btn-sm">
                All Notices <i class="fa fa-list"></i>
            </button>
        </a>
    @endcan

    @can('create_noticee_head')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createNotice">
                Add Notice <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan
</div>
 
@can('edit_notice_head')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-notice" data-id="{{ $notice->id }}"
        data-title="{{ $notice->title }}" data-content="{{ $notice->content }}" data-is_active="{{ $notice->is_active }}"
        data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_notice_head')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $notice->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $notice->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.notices.destroy', $notice->id) }}" accept-charset="UTF-8">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="underscore">{{ $notice->title }}</span>?</p>
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
