@can('edit_inventories')
    <a href="{{route('admin.inventories.edit' ,$inventory->id)}}" class="btn btn-outline-primary btn-sm mx-1 edit-inventory" data-id="{{ $inventory->id }}"
        data-inventory_head_id="{{ $inventory->inventory_head_id }}" data-name="{{ $inventory->name }}"
        data-unit="{{ $inventory->unit }}" data-date="{{ $inventory->date }}" data-amount="{{ $inventory->amount }}"
        data-description="{{ $inventory->description }}" data-document="{{ $inventory->document }}"
        data-status="{{ $inventory->status }}" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_inventories')
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#delete{{ $inventory->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="far fa-trash-alt"></i>
    </button>

    <div class="modal fade" id="delete{{ $inventory->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.inventories.destroy', $inventory->id) }}" accept-charset="UTF-8"
                    method="POST">
                    <div class="modal-body">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <p>Are you sure to delete <span id="underscore"> {{ $inventory->name }} </span>?</p>
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
