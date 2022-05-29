<?php

namespace App\Observers;

use App\Models\Exam;
use App\Models\ExamVisit;

class ExamVisitObserver
{
    public function created(Exam $exam)
    {
        ExamVisit::create(
            [
                'exam_id' => $exam->id,
            ]);
    }
}
