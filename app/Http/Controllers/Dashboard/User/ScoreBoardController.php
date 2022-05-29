<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ScoreBoard;
use Illuminate\Http\Request;

class ScoreBoardController extends Controller
{

    public function index()
    {
        $results = ScoreBoard::with(['exam'])->where('user_id' , auth()->user()->id)->get();
        return view('dashboard.users.all_scoreaboard' , compact('results' ));

    }
    public function show(Exam $exam_slug)
    {

        $results = $exam_slug->score_board()->where('exam_id'  , $exam_slug->id)->where('user_id' , auth()->user()->id)->first();
        $percentage = $results->percentage;
        $grade = $results->grade;
        $total_correct_answers = $results->total_correct_answers;
        return view('dashboard.users.scoreboard' , compact('percentage' , 'grade' , 'total_correct_answers'));
    }
}
