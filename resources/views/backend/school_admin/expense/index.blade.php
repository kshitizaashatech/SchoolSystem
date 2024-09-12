@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.expense.partials.action')
        </div>
        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">
                            <div class="report-table-container">
                                <div class="table-responsive">
                                    <table id="expense-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Expense Head</th>
                                                <th>Name</th>
                                                <th>Invoice Number</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Document</th>
                                                <th>Created At</th>
                                                <th>Status</th>
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

        <div class="modal fade" id="createExpense" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <form method="post" id="expenseForm" action="{{ route('admin.expenses.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodField" value="POST">
                            <input type="hidden" name="dynamic_id" id="dynamic_id">
                            <div class="col-md-12">
                                <div class="p-2 label-input">
                                    <label for="expensehead_id">Expense Head</label>
                                    <div class="select">
                                        <select id="dynamic_expensehead_id" name="expensehead_id" data-iteration="0"
                                            class="expensehead_id" required>
    
                                            <option disabled selected value="{{ old('expensehead_id') }}">Select Expense Head
                                            </option>
                                            @foreach ($expenseshead as $expense)
                                                <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('expensehead_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="p-2 label-input">
                                    <label>Name<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('name') }}" name="name" class="input-text single-input-text"
                                            id="dynamic_name" autofocus required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Invoice Number<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('invoice_number') }}" name="invoice_number"
                                            class="input-text single-input-text" id="dynamic_invoice_number" required>
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label for="datetimepicker">Date:</label>
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                            <input id="nepali-datepicker" name="date" type="text"
                                                value="{{ old('date') }}" class="form-control" />

                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Amount<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <input type="text" value="{{ old('amount') }}" name="amount" class="input-text single-input-text"
                                            id="dynamic_amount" required>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Description<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <textarea name="description" class="input-text single-input-text" id="dynamic_description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 label-input">
                                    <label>Document</label>
                                    <div class="single-input-modal">
                                        <input type="file" value="{{ old('document') }}" name="document"
                                            class="input-text single-input-text" id="dynamic_document">
                                    </div>
                                </div>

                                <div class="p-2 label-input">
                                    <label>Status<span class="must">*</span></label>
                                    <div class="single-input-modal">
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="is_active" id="option1"
                                                value="1" autocomplete="off" checked />
                                            <label class="btn btn-secondary" for="option1">Active</label>

                                            <input type="radio" class="btn-check" name="is_active" id="option2"
                                                value="0" autocomplete="off" />
                                            <label class="btn btn-secondary" for="option2">Inactive</label>
                                        </div>
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

<script

src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"
        type="text/javascript"></script>

    <script type="text/javascript">
        $("#nepali-datepicker").nepaliDatePicker();
        $("#nepali-datepicker").nepaliDatePicker({
            container: "#createExpense",
            dateFormat: "YYYY-MM-DD",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#expense-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.expenses.get') }}',
                type: 'POST'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'expensehead_id',
                    name: 'expensehead_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'invoice_number',
                    name: 'invoice_number'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'document',
                    name: 'document'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
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
        $(document).on('click', '.edit-expense', function() {
            console.log('Edit button clicked!');
            var id = $(this).data('id');
            var expensehead = $(this).data('expensehead_id');
            var name = $(this).data('name');
            var invoice_number = $(this).data('invoice_number');
            var date = $(this).data('date');
            var amount = $(this).data('amount');
            var description = $(this).data('description');
            var document = $(this).data('document');
            var is_active = $(this).data('is_active');

            $('#dynamic_id').val(id);
            $('#dynamic_expensehead_id').val(expensehead);
            $('#dynamic_name').val(name);
            $('#dynamic_invoice_number').val(invoice_number);
            $('#dynamic_date').val(date);
            $('#dynamic_amount').val(amount);
            $('#dynamic_description').val(description);
            // $('#dynamic_document').val(document);
            // $('#dynamic_description').val(description);
            var fileInput = $('#dynamic_document');
            fileInput.replaceWith(fileInput.val('').clone(true));

            $('input[name="is_active"]').prop('checked', false);
            $('input[name="is_active"][value="' + is_active + '"]').prop('checked', true);

            // $('#expenseForm').attr('action', '{{ route('admin.expenses.update', '') }}' + '/' +
            //     id);
            $('#expenseForm').attr('action', '{{ route('admin.expenses.update', '') }}' + '/' + id);
            $('#methodField').val('PUT');

            $('#createExpense').modal('show');

            return false;
        });
    </script>
@endsection
@endsection
