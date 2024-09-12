<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_teacher_logs')
        <a href="{{ route('admin.teacher-logs.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    @can('create_teacher_logs')
        <a href={{ route('admin.teacher-logs.create') }}>
            <button type="button" class="btn btn-block btn-success btn-sm">
                Add Teacher's Logs <i class="fas fa-lock"></i>
            </button>
        </a>
    @endcan
</div>
