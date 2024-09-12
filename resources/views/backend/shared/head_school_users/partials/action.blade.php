<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    <a href="{{ route('admin.head-schoolusers.index') }}"><button class="btn-info btn-sm">All List <i class="fa fa-list"></i></button></a>

    <a href="{{ route('admin.head-schoolusers.create') }}">
        <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
            data-bs-target="#createHeadSchoolUser">
            Add Head School User <i class="fas fa-plus"></i>
        </button>
    </a>

</div>
