@extends('backend.layouts.master')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            {{-- @include('backend.school_admin.assign_class_teacher.partials.action') --}}
        </div>
        <div class="card">
            <div class="card-body">
                <div>
                    {{-- <canvas id="myChart"></canvas> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
