<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>

    {{-- No permission Available --}}
    <a href="{{ route('admin.students-session.index') }}"><button class="btn-info btn-sm">All List <i
                class="fa fa-list"></i></button></a>
    {{-- No permission Available --}}

    {{-- No permission Available --}}
    <a href="#">
        <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
            data-bs-target="#createStudent_session">
            Add Student Session <i class="fas fa-plus"></i>
        </button>
    </a>
    {{-- No permission Available --}}

</div>
