<?php

namespace App\Http\Controllers\Dashboard\Creator;

use App\DataTables\CreatorRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Http\Request;
use App\Models\Request as RequestModel;

class RequestController extends Controller
{
    public function __invoke(Request $request , CreatorRequestDataTable $dataTable ,  Creator $slug , $exam_id = null , $user_id = null)
    {
        if($request->getMethod() == 'GET') {
            return $dataTable->render('dashboard.creator.request_access');
        }


        if(is_null($exam_id)  && is_null($user_id)) {

            abort(403);
        }


        RequestModel::whereExamIdAndUserId( $exam_id , $user_id)->update(['access' => true] );


        return response()->json(['data' => 'done']);


    }
}
