@extends('backend.layouts.master')

@section('content')

@if(isset($examResults) && $examResults->count() > 0)
<h3>Exam Results for Student: {{ $studentName }}</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Subject</th>
                <th>Attendance</th>
                <th>Participant Assessment</th>
                <th>Practical Assessment</th>
                <th>Theory Assessment</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examResults as $result)
            <tr>
                <td>{{ $result->subject->subject }}</td>
                <td class="{{ $result->attendance == 0 ? 'text-success' : ($result->attendance == 1 ? 'text-danger' : 'text-muted') }}">
                    {{ $result->attendance == 0 ? 'Present' : ($result->attendance == 1 ? 'Absent' : 'N/A') }}
                </td>
                <td>{{ $result->participant_assessment ?? 'N/A' }}</td>
                <td>{{ $result->practical_assessment ?? 'N/A' }}</td>
                <td>{{ $result->theory_assessment ?? 'N/A' }}</td>
                <td>{{ $result->notes ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No exam results found for this student.</p>
@endif

@endsection

@section('styles')
<style>
    .table {
        border-collapse: collapse;
        width: 100%;
    }
    .table th, .table td {
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: left;
    }
    .table thead th {
        background-color: #343a40;
        color: white;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endsection
