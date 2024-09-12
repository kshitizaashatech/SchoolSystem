@extends('backend.layouts.master')

@section('content')
<div class="container">
    <h2>Inventory Details</h2>
    
    <div class="card">
        <div class="card-body">
            <p><strong>School:</strong> {{ $inventory->school ? $inventory->school->name : 'N/A' }}</p>
            <p><strong>Inventory Head:</strong> {{ $inventory->inventoryHead ? $inventory->inventoryHead->name : 'N/A' }}</p>
            <p><strong>Item Name:</strong> {{ $inventory->name }}</p>
            <p><strong>Unit:</strong> {{ $inventory->unit }}</p>
            <p><strong>Description:</strong> {{ $inventory->description }}</p>
            <p><strong>Status:</strong> {{ $inventory->status ? 'Yes' : 'No' }}</p>
            <p><strong>Date Added:</strong> {{ $inventory->created_at }}</p>
        </div>
    </div>
    <a href="{{ route('admin.municipalityAdmin.inventoryReport.report') }}" class="btn btn-primary mt-3">Back to Report</a>
</div>
@endsection