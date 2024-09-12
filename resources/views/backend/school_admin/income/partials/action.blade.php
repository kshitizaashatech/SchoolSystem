<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_incomes')
        <a href="{{ route('admin.incomes.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan

    @can('create_incomes')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createIncome">
                Add Income <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan
</div>
