@extends('backend.layouts.master')

@section('content')

<div class="mt-4">
    <div class="d-flex justify-content-between mb-4">
        <div class="border-bottom border-primary">
            <h2>{{ $page_title }}</h2>
        </div>
        @include('backend.school_admin.fee_collection.partials.action')
    </div>



</div>  <!-- Add the Search button -->

<table class="table table-bordered">
    <tr>

        @if($studentDetails->student_photo)
        <img src="{{ asset($studentDetails->student_photo) }}" alt="Student Photo" height="100" width="100">
    @else
        <span>No photo available</span>
    @endif
    </tr>
    <tr>

        <th>Name:</th>
        <td>{{ $studentDetails->f_name }} {{ $studentDetails->l_name }}</td>
        <th>Father Name:</th>
        <td>{{ $studentDetails->father_name }}</td>
    </tr>
    <tr>
        <th>Mobile Number:</th>
        <td>{{ $studentDetails->mobile_number }}</td>
        <th>Admission No:</th>
        <td>{{ $studentDetails->admission_no }}</td>
    </tr>
    <tr>
        <th>Class (Section):</th>
        <td colspan="3">{{ $classDetails->class }} {{ $sectionDetails->section_name }}</td>


    </tr>

    <tr>
        <td>
            <!-- Print Button -->
            <button class="btn btn-primary">Print</button>
            <!-- Collect Selected Button -->
            <button class="btn btn-success">Collect Selected</button>
        </td>
    </tr>

</table>


@endsection

