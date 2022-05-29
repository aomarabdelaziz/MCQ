<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CreatorExamsIndexDatatable;
use App\DataTables\QuestionsPreviewDataTable;
use App\Helpers\GetTriviaApiToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatorStoreRequest;
use App\Models\Creator;
use App\Models\Exam;
use App\Models\TriviaQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;


class CreatorController extends Controller
{



    /**
     * @param CreatorExamsIndexDatatable $dataTable
     * @param Creator $slug
     * @return mixed
     */
    public function index(CreatorExamsIndexDatatable $dataTable , Creator $slug)
    {

        return $dataTable->render('dashboard.creator.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Creator $slug)
    {
        return view('dashboard.creator.create' , compact('slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatorStoreRequest $request , Creator $slug)
    {


        $verify = App::environment('local') ? false : true;

        $response =  Http::withOptions(['verify' => $verify])->get('https://opentdb.com/api.php' ,
            [
                'amount' => $request->number_of_questions,
                'category' => $request->trivia_category,
                'difficulty' => $request->trivia_difficulty,
                'type' => $request->trivia_type,
            ]);

        $response = json_decode($response);

        if($response->response_code == 0)
        {
            $exam = $slug->exams()->create(
                [
                    'exam_name' => $request->exam_name,
                    'request_access' => $request->request_access,
                    'activated_at' => $request->activated_at,
                    'deactivated_at' => $request->deactivated_at,
                    'number_of_questions' => $request->number_of_questions,
                    'category_id' => $request->trivia_category,
                    'difficulty' => $request->trivia_difficulty,
                    'type' => $request->trivia_type,
                ]);

            foreach($response->results as $key => $question) {

               $questions =  TriviaQuestion::create(
                    [
                        'exam_id' => $exam->id,
                        'question' => $question->question,
                        'correct_answer' => $question->correct_answer,
                        'incorrect_answers' => $question->incorrect_answers,
                    ]);
            }

            return redirect()->route('creator.dashboard.show' ,  ['slug' => $slug , 'exam_slug' => $exam]);
        }
        else
        {
            if($response->response_code == 3 || $response->response_code == 4) {
                $token  = GetTriviaApiToken::generate(true , $slug);
                $slug->trivia_token = $token;
                $slug->save();
            }

           return  redirect()->back()->withInput()->with('errorRetrieveQuestion' , $this->getMessageByResponseCode($response->response_code));
        }




    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Creator $slug , Exam $exam_slug)
    {
        $triviaQuestions = TriviaQuestion::where('exam_id' , $exam_slug->id)->get();




        return view('dashboard.creator.preview' , compact('slug' , 'triviaQuestions' , 'exam_slug'));
    }


    /**
     * @param Creator $slug
     * @param Exam $exam_slug
     */
    public function changeAccess(Creator $slug , Exam $exam_slug)
    {

        if($exam_slug->request_access == true ) {
            $exam_slug->request_access = false;
        }
        else {
            $exam_slug->request_access = true;
        }

         $exam_slug->save();
         return response()->json(['status' => '200']);
    }



    /**
     * @param $code
     * @return string
     */
    public function getMessageByResponseCode($code)
    {
        return match($code) {
            1 => "No Results Could not return results. The API doesn't have enough questions for your query. (Ex. Asking for 50 Questions in a Category that only has 20.)",
            2 => "Invalid Parameter Contains an invalid parameter. Arguements passed in aren't valid. (Ex. Amount = Five)",
            3 => "Token Not Found Session Token does not exist.",
            4 => "Token Empty Session Token has returned all possible questions for the specified query. Resetting the Token is necessary.",
        };
    }
}
