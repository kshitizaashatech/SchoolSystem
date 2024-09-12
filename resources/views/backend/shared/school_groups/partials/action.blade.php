<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    <a href="{{ route('admin.school-groups.index') }}"><button class="btn-info btn-sm">All List <i class="fa fa-list"></i></button></a>

    <a href="#">
        <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
            data-bs-target="#createSchoolGroups">
            Add School Group <i class="fas fa-plus"></i>
        </button>
    </a>

</div>