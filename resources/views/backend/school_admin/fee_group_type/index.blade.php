@extends('backend.layouts.master')

@section('content')

<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.fee_group_type.partials.action')
    </div>
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-12">
                        <div class="report-table-container">
                            <div class="table-responsive">

                                <table
                                    class="table table-striped table-bordered table-hover example dataTable no-footer">
                                    <thead>
                                        <tr role="row">
                                            <th>Fees Group</th>
                                            <th>Fees Type / Amount</th>
                                            <th class="text-right noExport">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $feeGroupName => $feeGroupTypes)

                                        <tr>
                                            <td>{{ $feeGroupName }}</td>
                                            <td>
                                                <ul class="liststyle1">
                                                    @foreach ($feeGroupTypes as $feeGroupType)

                                                    <li>
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                {{ $feeGroupType->fee_group_type_name }}

                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $feeGroupType->amount }}
                                                            </div>
                                                            <div class="col-md-3">

                                                                @include('backend.school_admin.fee_group_type.partials.controller_action',
                                                                ['feeGroupType' => $feeGroupType])


                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-right">
                                                {{-- Your action buttons here --}}
                                                <a href="{{ route('admin.fee-assignstudents') }}" class="btn btn-outline-success btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Create">
                                                    <i class="fas fa-plus"></i> Assign Student
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- For popup model --}}
    <div class="modal fade" id="createFeeGroupType" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Fee Group Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <form id="feeGroupTypeForm" method="post" action="{{ route('admin.fee-grouptypes.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">
                        <input type="hidden" name="dynamic_id" id="dynamic_id">

                        <!-- Add the dropdown for fee_groups_types -->
                        <div class="col-md-4 col-xs-12">
                            <label for="fee_group_id">Fee Group</label>
                            <select name="fee_group_id" id="dynamic_fee_group_id" class="form-control" required>
                                <option value="" disabled selected>Select Fee Group Type</option>
                                @foreach($feeGroups as $feeGroupType)
                                <option value="{{ $feeGroupType->id }}">{{ $feeGroupType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 d-flex flex-wrap gap-5">
                            <div class="form-group col-md-4 col-xs-12">
                                <label>Amount<span class="must">*</span></label>
                                <input type="text" value="{{ old('amount') }}" name="amount" class="input-text"
                                    id="dynamic_amount" required>
                            </div>

                            <!-- Add the dropdown for fee_groups_types -->
                            <div class="col-md-4 col-xs-12">
                                <label for="fee_type_id">Fee Type</label>
                                <select name="fee_type_id" id="dynamic_fee_type_id" class="form-control" required>
                                    <option value="" disabled selected>Select Fee Group Type</option>
                                    @foreach($feeTypes as $feeType)
                                    <option value="{{ $feeType->id }}">{{ $feeType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Add the dropdown for fee_groups_types -->
                            <div class="col-md-4 col-xs-12">
                                <label for="academic_session_id">Academic Session</label>
                                <select name="academic_session_id" id="dynamic_academic_session_id" class="form-control"
                                    required>
                                    <option value="" disabled selected>Select Fee Group Type</option>
                                    @foreach($academic_session as $academicSession)
                                    <option value="{{ $academicSession->id }}">{{ $academicSession->session }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2 label-input">
                                <label>Status<span class="must">*</span></label>
                                <div class="col-sm-10">
                                    <div class="btn-group">
                                        <input type="radio" class="btn-check" name="is_active" id="option1" value="1"
                                            autocomplete="off" checked />
                                        <label class="btn btn-secondary" for="option1">Active</label>

                                        <input type="radio" class="btn-check" name="is_active" id="option2" value="0"
                                            autocomplete="off" />
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

    {{-- For popup model --}}
</div>

@section('scripts')


<script>
    $(document).on('click', '.edit-fee-group-type', function(event) {
    var button = $(event.currentTarget);
    var feeGroupId = button.data('id');
    var amount = button.data('amount');
    var feeTypeId = button.data('fee_type_id');
    var academicSessionId = button.data('academic_session_id');
    var isActive = button.data('is_active');
    var method = button.data('method');

    $('#dynamic_id').val(feeGroupId);
    $('#dynamic_fee_group_id').val(feeGroupId);
    $('#dynamic_amount').val(amount);
    $('#dynamic_fee_type_id').val(feeTypeId);
    $('#dynamic_academic_session_id').val(academicSessionId);
    $('input[name="is_active"]').prop('checked', isActive == 1);

    // Set the correct action attribute for the form
    $('#feeGroupTypeForm').attr('action', '{{ route('admin.fee-grouptypes.update', '') }}' + '/' + feeGroupId);
    $('#methodField').val('PUT');

    // Show the modal
    $('#createFeeGroupType').modal('show');

    // Prevent the default action of the link
    return false;
});
</script>
@endsection
@endsection
