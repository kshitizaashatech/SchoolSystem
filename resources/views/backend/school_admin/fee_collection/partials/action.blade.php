<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_fee_collections')
        <a href="{{ route('admin.fee-collections.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    {{-- @can('create_fee_collections')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createFeeCollection">
                Add Fee Collection <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan --}}
</div>
