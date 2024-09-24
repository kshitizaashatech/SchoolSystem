@can('edit_eca_activities')
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 edit-eca-activity" data-id="{{ $ecaActivity->id }}"
        data-title="{{ $ecaActivity->title }}" data-description="{{ $ecaActivity->description }}"
        data-is_active="{{ $ecaActivity->is_active }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_eca_activities')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $ecaActivity->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $ecaActivity->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.eca_activities.destroy', $ecaActivity->id) }}"
                    accept-charset="UTF-8">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure you want to delete <span id="underscore">{{ $ecaActivity->title }}</span>?</p>
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