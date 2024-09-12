<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_topics')
        <a href="{{ route('admin.topics.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan


    @can('create_topics')
        <a href="#" class="btn btn-block btn-success btn-sm createTopic">
            {{-- <button type="button" data-bs-toggle="modal"
                data-bs-target="#createTopic">
            </button> --}}
            Add Topic <i class="fas fa-plus"></i>
        </a>
    @endcan
</div>
