@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom_scoreboard.css') }}">
@endpush
@section('content')
    <div class="container d-flex justify-content-center mt-4">
        <div class="card p-3 mt-3">
            <h5 class="mt-3 mb-3">Exam Results Score</h5>
            <div class="border p-2 rounded d-flex flex-row align-items-center">
                <div class="p-1 px-4 d-flex flex-column align-items-center score rounded"> <span class="d-block char text-success">{{ $grade}}</span> <span class="text-success">{{ $percentage }}</span> </div>
                <div class="ml-2 p-3">
                    <h6 class="heading1">Exam Score</h6> <span>The average score is {{ $percentage }} %</span>
                </div>
            </div>

        </div>
    </div>
@endsection
