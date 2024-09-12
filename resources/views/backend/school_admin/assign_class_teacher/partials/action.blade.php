<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_assign_classteachers')
        <a href="{{ route('admin.assign-classteachers.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    @can('create_assign_classteachers')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createClass">
                Add Class Teacher <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan
</div>
