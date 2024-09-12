<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_examinations')
        <a href="{{ route('admin.primary-examinations.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan


    @can('create_primary_examinations')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createExamination">
                Add Primary Examination <i class="fas fa-user-plus"></i>
            </button>
        </a>
    @endcan
</div>
