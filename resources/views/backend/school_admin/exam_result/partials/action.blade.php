<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('create_generate_results')
        <a href="{{ route('admin.generate-results.export', $examinations->id) }}"><button class="btn-success btn-sm">Export
                Results <i class="fa fa-file-excel"></i></button></a>
    @endcan
</div>
