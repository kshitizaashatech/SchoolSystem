@extends('backend.layouts.master')
@section('content')
<div class="container">
    <h2>Inventory Report</h2>
    
    <div class="row">
        <div class="col-md-3">
            <label for="school_id">Select School:</label>
            <select id="school_id" class="form-control">
                <option value="">All Schools</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="inventory_name">Inventory Title:</label>
            <input type="text" id="inventory_name" class="form-control">
        </div>
        {{-- <div class="col-md-3">
            <label for="date">Select Date:</label>
            <input type="date" id="date" class="form-control" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
        </div> --}}
        <div class="col-md-3">
            <button id="filter" class="btn btn-primary mt-4">Search</button>
        </div>
    </div>
    
    <table id="inventoryTable" class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>School Name</th>
                <th>Inventory Head</th>
                <th>Item Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.municipalityAdmin.inventoryReport.getData") }}',
                data: function(d) {
                    // d.date = $('#date').val();
                    d.school_id = $('#school_id').val();
                    d.inventory_name = $('#inventory_name').val();
                }
            },
            columns: [
                { data: 'school_name', name: 'school_name' },
                { data: 'inventory_head_name', name: 'inventory_head_name' },
                { data: 'item_name', name: 'item_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#filter').click(function() {
            table.draw();
        });
    });
</script>
@endsection