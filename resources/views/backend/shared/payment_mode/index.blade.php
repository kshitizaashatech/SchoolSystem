@extends('backend.layouts.master')

@section('content')


    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.shared.payment_mode.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="paymentmode-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Payment Mode</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createPaymentMode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Payment Mode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="paymentmodeform" action="{{ route('super-admin.payment-mode.store') }}">
                            @csrf

                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12 d-flex flex-wrap gap-5">
                                <div class="form-group col-md-4 col-xs-12">
                                    <label>Payment Mode<span class="must">*</span></label>
                                    <input type="text" value="{{ old('payment_mode') }}" name="payment_mode" class="input-text"
                                        id="dynamic_payment_mode" autofocus required>
                                </div>

                                <div class="form-group col-md-4 col-xs-12">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_active" id="option1"
                                            value="1" autocomplete="off" checked />
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_active" id="option2"
                                            value="0" autocomplete="off" />
                                        <label class="btn btn-secondary" for="option2">Inactive</label>
                                    </div>
                                </div>

                                <div class="border-top col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#paymentmode-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('super-admin.payment-mode.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'payment_mode',
                    name: 'payment_mode'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val()).draw();
                        });
                });
            }
        });

        $(document).on('click', '.edit-payment-mode', function() {

            var id = $(this).data('id');
            console.log(id);
            var payment_mode = $(this).data('payment_mode');
            var is_active = $(this).data('is_active');

            $('#dynamic_id').val(id);
            $('#dynamic_payment_mode').val(payment_mode);

            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            var newActionValue = "new/action/url"; // Replace this with the new action URL

        // $('#wer').attr('action', newActionValue);

            $('#paymentmodeform').attr('action', '{{ route('super-admin.payment-mode.update', '') }}' + '/' + id);
            // $('#paymentModeForm').attr('action',
            //     id);
            $('#methodField').val('PUT');

            $('#createPaymentMode').modal('show');

            return false;
        });
    </script>
@endsection
@endsection
