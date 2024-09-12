<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_subject_groups')
        <a href="{{ route('admin.subject-groups.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    @can('create_subject_groups')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm createSubject">
                Add Subject Group <i class="fas fa-user-plus"></i>
            </button>
        </a>
    @endcan
</div>
