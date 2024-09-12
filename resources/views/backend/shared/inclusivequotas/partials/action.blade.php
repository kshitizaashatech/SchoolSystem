<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_inclusive_quotas')
        <a href="{{ route('admin.inclusive-quotas.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan

    @can('create_inclusive_quotas')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createInclusive">
                Add Inclusive Quotas <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan

</div>
