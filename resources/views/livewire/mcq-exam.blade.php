<div class="border">
    <div class="question bg-white p-3 border-bottom">
        <div class="d-flex flex-row justify-content-between align-items-center mcq">
            <h4>{{ $exam_slug->exam_name }}</h4><span>({{ $current + 1}} of {{ $total }})</span>
        </div>
    </div>

    <div class="question bg-white p-3 border-bottom">
        <div class="d-flex flex-row align-items-center question-title">
            <h3 class="text-danger">Q.{!! $question !!}</h3>
            <h5 class="mt-1 ml-2"></h5>
        </div>
        <div class="ans ml-4">
            <label class="radio"> <input wire:click="setUserAnswer('{{ $choosenAnswers[0] }}')" type="radio" name="trivia_exam" value="{{ $choosenAnswers[0] }}"> <span>{{ $choosenAnswers[0] }}</span>
            </label>
        </div>
        <div class="ans ml-4">
            <label class="radio"> <input wire:click="setUserAnswer('{{ $choosenAnswers[1] }}')" type="radio" name="trivia_exam" value="{{ $choosenAnswers[1] }}"> <span>{{ $choosenAnswers[1] }}</span>
            </label>
        </div>
        <div class="ans ml-4">
            <label class="radio"> <input wire:click="setUserAnswer('{{ $choosenAnswers[2] }}')" type="radio" name="trivia_exam" value="{{ $choosenAnswers[2] }}"> <span>{{ $choosenAnswers[2] }}</span>
            </label>
        </div>
        <div class="ans ml-4">
            <label class="radio"> <input wire:click="setUserAnswer('{{ $choosenAnswers[3] }}')" type="radio" name="trivia_exam" value="{{ $choosenAnswers[3] }}"> <span>{{ $choosenAnswers[3] }}</span>
            </label>
        </div>

    </div>
    <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white">


        @if($this->current == 0)
            <button wire:click="previousQuestion()" style="cursor: not-allowed" disabled class="btn btn-primary d-flex align-items-center btn-danger" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;previous</button>
        @else
            <button wire:click="previousQuestion()" class="btn btn-primary d-flex align-items-center btn-danger" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;previous</button>
        @endif

        @if($this->showNextButton)
                @if($this->current !== count($this->ids) - 1)
                    <button  wire:click="nextQuestion()" class="btn btn-primary border-success align-items-center btn-success" type="button">Next<i class="fa fa-angle-right ml-2"></i></button>
                @else
                    <button wire:click="submit()" class="btn btn-primary border-success align-items-center btn-success" type="button">Submit<i class="fa fa-angle-right ml-2"></i></button>

                @endif
        @endif
    </div>

</div>
