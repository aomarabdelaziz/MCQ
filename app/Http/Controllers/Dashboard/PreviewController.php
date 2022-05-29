<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\Exam;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    public function approve(Creator $slug, Exam $exam_slug)
    {
       $exam_slug->status = 'Approved';
       $exam_slug->save();

       return redirect()->route('creator.dashboard' , ['slug' => $slug] )->with('success' , 'Exam has been approved');
    }

    public function disapprove(Creator $slug , Exam $exam_slug)
    {
        $exam_slug->delete();
        return redirect()->route('creator.dashboard' , ['slug' => $slug] )->with('success' , 'Exam has been disapproved');

    }
}
