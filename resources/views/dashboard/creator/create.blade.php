@extends('layouts.app')

@push('css')

@endpush
@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Add New Exam') }}</h2>
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

                @if(session('errorRetrieveQuestion'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                    </svg>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            {{ session('errorRetrieveQuestion') }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('creator.dashboard.store' , ['slug' => $slug]) }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-12">
                            <div class="input-style-1">
                                <label>{{ __('Exam Name') }}</label>
                                <input type="text" value="{{ old('exam_name' , request('exam_name'))  }}" @error('exam_name') class="form-control is-invalid" @enderror name="exam_name"
                                       id="exam_name" placeholder="{{ __('Exam Name') }}">
                                @error('exam_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-style-1">
                                        <label>{{ __('Activated at') }}</label>
                                        <div class='input-group date' id='activated_at'>
                                            <input type='datetime-local'  value="{{ old('activated_at' , request('activated_at')) }}" @error('activated_at') class="form-control is-invalid" @enderror name="activated_at" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            @error('activated_at')
                                            <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-style-1">
                                        <label>{{ __('Deactivated at') }}</label>
                                        <div class='input-group date'  id='deactivated_at'>
                                            <input type='datetime-local'  value="{{ old('deactivated_at' , request('deactivated_at')) }}" @error('deactivated_at') class="form-control is-invalid" @enderror name="deactivated_at" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            @error('deactivated_at')
                                            <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label>{{ __('Number Of Questions') }}</label>
                                <input type="number" min="1" value= "{{ old('number_of_questions' , request('number_of_questions'))  }}"  max="50" @error('number_of_questions') class="form-control is-invalid" @enderror name="number_of_questions"
                                       id="number_of_questions" placeholder="{{ __('Number Of Questions') }}">
                                @error('number_of_questions')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                <span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-style-1">
                                        <label>{{ __('Request Access') }}</label>
                                        <select  name="request_access" class="form-control">
                                            <option value="0" @if(old('request_access') == 0) selected @endif> Enable </option>
                                            <option value="1" @if(old('request_access') ==1) selected @endif> Disable </option>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-style-1">
                                        <label>{{ __('Select Category') }}</label>
                                        <select name="trivia_category" @error('trivia_category') class="form-control is-invalid" @enderror class="form-control">
                                          {{--  <option value="any" @if(old('trivia_category') == 'any') selected @endif> Any Category </option>--}}
                                            <option value="">-- Select Category --</option>

                                            <option value="9" @if(old('trivia_category') == 9) selected @endif> General Knowledge</option>
                                            <option value="10" @if(old('trivia_category') == 10) selected @endif> Entertainment: Books</option>
                                            <option value="11" @if(old('trivia_category') == 11) selected @endif> Entertainment: Film</option>
                                            <option value="12" @if(old('trivia_category') == 12) selected @endif> Entertainment: Music</option>
                                            <option value="13" @if(old('trivia_category') == 13) selected @endif> Entertainment: Musicals &amp; Theatres</option>
                                            <option value="14" @if(old('trivia_category') == 14) selected @endif> Entertainment: Television</option>
                                            <option value="15" @if(old('trivia_category') == 15) selected @endif> Entertainment: Video Games</option>
                                            <option value="16" @if(old('trivia_category') == 16) selected @endif> Entertainment: Board Games</option>
                                            <option value="29" @if(old('trivia_category') == 29) selected @endif> Entertainment: Comics</option>
                                            <option value="29" @if(old('trivia_category') == 29) selected @endif> Entertainment: Comics</option>
                                            <option value="31" @if(old('trivia_category') == 31) selected @endif> Anime &amp; Manga</option>
                                            <option value="32" @if(old('trivia_category') == 32) selected @endif>Cartoon &amp; Animations</option>

                                            <option value="17" @if(old('trivia_category') == 17) selected @endif> Science &amp; Nature</option>
                                            <option value="18" @if(old('trivia_category') == 18) selected @endif> Science: Computers</option>
                                            <option value="19" @if(old('trivia_category') == 19) selected @endif> Science: Mathematics</option>
                                            <option value="30" @if(old('trivia_category') == 30) selected @endif> Science: Gadgets</option>

                                            <option value="20" @if(old('trivia_category') == 20) selected @endif> Mythology</option>
                                            <option value="21" @if(old('trivia_category') == 21) selected @endif> Sports</option>
                                            <option value="22" @if(old('trivia_category') == 22) selected @endif> Geography</option>
                                            <option value="23" @if(old('trivia_category') == 23) selected @endif> History</option>
                                            <option value="24" @if(old('trivia_category') == 24) selected @endif> Politics</option>
                                            <option value="25" @if(old('trivia_category') == 25) selected @endif> Art</option>
                                            <option value="26" @if(old('trivia_category') == 26) selected @endif> Celebrities</option>
                                            <option value="27" @if(old('trivia_category') == 27) selected @endif> Animals</option>
                                            <option value="28" @if(old('trivia_category') == 28) selected @endif> Vehicles</option>


                                        </select>
                                        @error('trivia_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        <span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-style-1">
                                        <label >{{ __('Select Difficulty') }}</label>
                                        <select name="trivia_difficulty"  @error('trivia_difficulty') class="form-control is-invalid" @enderror class="form-control">
                                          {{--  <option value="any" @if(old('trivia_difficulty') == 'any') selected @endif>Any Difficulty</option>--}}
                                            <option value="">-- Select Difficulty --</option>
                                            <option value="easy" @if(old('trivia_difficulty') == 'easy') selected @endif>Easy</option>
                                            <option value="medium" @if(old('trivia_difficulty') == 'medium') selected @endif>Medium</option>
                                            <option value="hard" @if(old('trivia_difficulty') == 'hard') selected @endif>Hard</option>
                                        </select>
                                        @error('trivia_difficulty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        <span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-style-1">
                                        <label>{{ __('Select Type') }}</label>
                                        <select name="trivia_type" @error('trivia_type') class="form-control is-invalid" @enderror class="form-control">

                                          {{--  <option value="any" @if(old('trivia_type') == 'any') selected @endif>Any Type</option>--}}
                                            <option value="">-- Select Type --</option>
                                            <option value="multiple" @if(old('trivia_type') == 'multiple') selected @endif>Multiple Choice</option>
                                            <option value="boolean" @if(old('trivia_type') == 'boolean') selected @endif>True / False</option>

                                        </select>
                                        @error('trivia_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        <span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')





@endpush
