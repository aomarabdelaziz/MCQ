<?php

namespace App\Http\Livewire;

use App\Models\Exam;
use App\Models\Request;
use App\Models\TriviaQuestion;
use Illuminate\View\View;
use Livewire\Component;

class McqExam extends Component
{

    /**
     * @var Exam
     */
    public Exam $exam_slug ;
    /**
     * @var array
     */
    public array $ids = [];
    /**
     * @var int
     */
    public int $current = 0;

    /**
     * @var string
     */
    public string $question = '';

    /**
     * @var array
     */
    public array $incorrect_answers = [];

    /**
     * @var array
     */
    public array $choosenAnswers = [];

    /**
     * @var string
     */
    public string $userChossenAnswer = '';

    /**
     * @var int
     */
    public int $totalUserCorrectAnswer = 0;

    /**
     * @var array
     */
    public array $storedUserData = [];

    /**
     * @var bool
     */
    public $showNextButton = false;



    /**
     * @param Exam $exam_slug
     */
    public function mount(Exam $exam_slug) : void
    {

        $isUserAllowed = false;
        if($exam_slug->request_access == false )
        {

            if($this->exam_slug->access()->whereUserId(auth()->user()->id)->exists() )
            {
               $isUserAllowed = $this->exam_slug->access()->whereUserId(auth()->user()->id)->select('access')->first()->access;

            }
            else
            {
                Request::create(
                    [
                        'user_id' => auth()->user()->id,
                        'exam_id' => $this->exam_slug->id,
                        'access' => 0
                    ]);
            }
        }

        $isUserAllowed  = $this->exam_slug->access()->whereUserId(auth()->user()->id)->select('access')->first()->access;


        if(!$isUserAllowed || $exam_slug->status == 'pending' || now()->isAfter($exam_slug->deactivated_at) || now()->isBefore($exam_slug->activated_at))
            abort(403);


        $this->exam_slug = $exam_slug;
        $this->ids = $exam_slug->questions()->inRandomOrder()->pluck('id')->toArray();
        $this->total = count($this->ids);

        $this->getQuestion();

    }

    /**
     * @return mixed
     */
    public function render() : View
    {
        return view('livewire.mcq-exam' )->layout('layouts.live-wire' , ['title' => $this->exam_slug->exam_name]);
    }

    /**
     *
     */
    public function getQuestion() : void
    {
        $id = $this->ids[0];

        $data = TriviaQuestion::findOrFail($id);

        $this->question = $data->question;
        $this->correct_answer = $data->correct_answer;
        $this->incorrect_answers = $data->incorrect_answers;

        $this->pushData($this->choosenAnswers , $this->incorrect_answers , $this->correct_answer);



    }

    /**
     *
     */
    public function nextQuestion() : void
    {

        if($this->current !== count($this->ids) - 1)
        {
            $this->resetData(true);

            $id = $this->ids[$this->current];

            $data = TriviaQuestion::findOrFail($id);

            $this->question = $data->question;
            $this->correct_answer = $data->correct_answer;
            $this->incorrect_answers = $data->incorrect_answers;
            $this->pushData($this->choosenAnswers , $this->incorrect_answers , $this->correct_answer);


        }


    }


    /**
     *
     */
    public function previousQuestion() : void
    {

        if($this->current !== 0) {



            $this->resetData(false);

            $id = $this->ids[$this->current];

            $data = TriviaQuestion::findOrFail($id);

            $this->question = $data->question;
            $this->correct_answer = $data->correct_answer;
            $this->incorrect_answers = $data->incorrect_answers;

            $this->pushData($this->choosenAnswers , $this->incorrect_answers , $this->correct_answer);


        }


    }


    /**
     * @param bool $incrementOrNot
     */
    public function resetData(bool $incrementOrNot) : void
    {
        $this->showNextButton = false;
        $this->incorrect_answers = [];
        $this->choosenAnswers = [];
        $this->question = '';
        $this->correct_answer = '';


        if($incrementOrNot) {

            $this->current ++ ;

        }
        else {
            $this->current -- ;
        }

    }

    /**
     * @param array $target
     * @param ...$params
     */
    public function pushData(array &$target , ...$params) : void
    {


        foreach($params as $data)
        {

            if(is_array($data))
            {
                foreach($data as $items)
                {
                    array_push($target ,$items );
                }

            }
            else
            {
                array_push($target, $data);
            }

        }



    }

    /**
     * @param $answer
     */
    public function setUserAnswer($answer) : void
    {


        $this->showNextButton = true;
        $id = $this->ids[$this->current];

        if(key_exists($id , $this->storedUserData)) {

            $this->storedUserData[$id]['user_answer'] = $answer;
        }
        else {
            $this->storedUserData[$id] = ['user_answer' => $answer , 'correct_answer' => $this->correct_answer];
        }


    }

    /**
     *
     */
    public function submit()
    {

        foreach($this->storedUserData as $id => $value)
        {
            $correctAnswer = TriviaQuestion::findOrFail($id)->correct_answer;
            if($correctAnswer == $this->storedUserData[$id]['user_answer']) {
                $this->totalUserCorrectAnswer ++;
            }
        }


        $total = count($this->ids);
        $percentage = ($this->totalUserCorrectAnswer / $total) * 100;

        $this->exam_slug->score_board()->updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'exam_id' => $this->exam_slug->id,

            ] ,
            [
                'total_correct_answers' => $this->totalUserCorrectAnswer,
                'percentage' => $percentage,
                'grade' =>  $this->getGrade($percentage)

            ]);

        $this->exam_slug->exam_visits()->increment('visits');
        return redirect()->route('user.exam.scoreboard' , ['exam_slug' => $this->exam_slug]);

    }

    /**
     * @param $percentage
     * @return string
     */
    public function getGrade($percentage) : string
    {
        $grade =  '';
        if ($percentage < 65)
        {
            $grade = 'F';
        }
        else if ($percentage<= 66 && $percentage >=65)
        {
            $grade = 'D';
        }
        else if ($percentage <= 69 && $percentage >=67)
        {
            $grade = 'D+';
        }
        else if ($percentage <= 73 && $percentage >=70)
        {
            $grade = 'C-';
        }
        else if ($percentage <= 76 && $percentage >=74)
        {
            $grade = 'C';
        }
        else if ($percentage<= 79 && $percentage >=77 )
        {
            $grade = 'C+';
        }
        else if ($percentage <= 83 && $percentage >=80)
        {
            $grade = 'B-';
        }
        else if ($percentage <= 86 && $percentage >=84)
        {
            $grade = 'B';
        }
        else if ($percentage <= 89 && $percentage >=87)
        {
            $grade = 'B+';
        }
        else if ($percentage <= 93 && $percentage >=90)
        {
            $grade = 'A-';
        }
        else if ($percentage <= 96 && $percentage >=94)
        {
            $grade = 'A';
        }
        else if ($percentage >= 97)
        {
            $grade = 'A+';
        }


        return $grade;
    }



}
