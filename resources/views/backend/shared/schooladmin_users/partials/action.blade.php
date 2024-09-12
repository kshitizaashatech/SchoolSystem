<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_school_adminusers')
        <a href="{{ route('admin.school-adminusers.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    @can('create_school_adminusers')
        <a href="{{ route('admin.school-adminusers.create') }}"><button class="btn btn-block btn-success btn-sm">Add
                School Admin User<i class="fas fa-plus"></i></button></a>
    @endcan
</div>
