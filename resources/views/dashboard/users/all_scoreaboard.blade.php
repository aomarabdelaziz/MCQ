@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom_scoreboard.css') }}">
@endpush
@section('content')

    @foreach($results->chunk(3) as $items)
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-4">
                    <div class="card p-3 mt-3">
                        <h5 class="mt-3 mb-3">{{ $item->exam->exam_name }} Results Score</h5>
                        <div class="border p-2 rounded d-flex flex-row align-items-center">
                            <div class="p-1 px-4 d-flex flex-column align-items-center score rounded"> <span class="d-block char text-success">{{ $item->grade }}</span> <span class="text-success">{{ $item->percentage }}</span> </div>
                            <div class="ml-2 p-3">
                                <h6 class="heading1">Exam Score</h6> <span>The average score is {{ $item->percentage }} %</span>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        </div>
    @endforeach

@endsection
