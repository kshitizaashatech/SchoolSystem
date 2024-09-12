<div>
    @can('create_staffs_import')
        <a href="{{ route('admin.staffs_import.import') }}" style="text-decoration: none;">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal" data-bs-target="">
                Import Staffs <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_staffs')
        <a href="{{ route('admin.staffs.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    @can('create_staffs')
        <a href="{{ route('admin.staffs.create') }}"><button class="btn btn-block btn-success btn-sm">Add
                Staff<i class="fas fa-user-plus"></i></button></a>
    @endcan

    {{-- @can('create_staffs_leavedetails',)
    <a href="{{ route('admin.staffs.create') }}"><button class="btn btn-block btn-success btn-sm">Add Leave Details
        <i class="fas fa-user-plus"></i></button></a>
        
    @endcan

    @can('create_staffs_resignation_details',)
    <a href="{{ route('admin.staffs.create') }}"><button class="btn btn-block btn-success btn-sm">Add
            Resignation Details<i class="fas fa-user-plus"></i></button></a>
   @endcan --}}
</div>
