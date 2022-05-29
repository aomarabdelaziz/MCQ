@extends('layouts.app')
@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Admin Dashboard') }}</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                    <p class="text-bold">Exam Name: {{ $exam_slug->exam_name }}</p>
                    <p class="text-bold">Questions Count: {{ $triviaQuestions->count()  }}</p>

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if($exam_slug->status == 'pending')
                            <form action="{{ route('dashboard.creator.approve' , [ 'slug' => $slug,   'exam_slug' => $exam_slug]) }}" method="post">
                                @csrf

                                <div class="button-group d-flex justify-content-center flex-wrap">
                                    <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                        {{ __('Approve') }}
                                    </button>
                                </div>
                            </form>
                        @else

                                <form action="{{ route('dashboard.creator.disapprove' , ['slug' => $slug,    'exam_slug' => $exam_slug]) }}" method="post">
                                    @csrf
                                    <div class="button-group d-flex justify-content-center flex-wrap">
                                        <button type="submit" class="main-btn danger-btn btn-hover w-100 text-center">
                                            {{ __('Disapprove') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                    </div>

                </div>
        </div>

    </div>


    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th class="text-center"  scope="col">Question</th>
            <th class="text-center"  scope="col">Correct Answer</th>
            <th  class="text-center" scope="col">Incorrect Answer</th>
        </tr>
        </thead>
        <tbody>

        @foreach($triviaQuestions as $question)
            <tr>
                <td class="text-center" >{!! $question->question !!} </td>
                <td class="text-center" >{{ $question->correct_answer }}</td>
                <td class="text-center" >{{ json_encode($question->incorrect_answers) }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
