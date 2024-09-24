<div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>Notice Listing</h2>
        </div>
        <div>
            <a href="{{ url()->previous() }}">
                <button class="btn-primary btn-sm">
                    <i class="fa fa-angle-double-left"></i> Back
                </button>
            </a>
                <a href="#">
                    <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#createNotice">
                        Add Notice <i class="fas fa-plus"></i>
                    </button>
                </a>
        </div>
    </div>