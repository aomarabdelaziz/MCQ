<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreBoard extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =
        [
            'id',
            'user_id',
            'exam_id',
            'percentage',
            'grade',
            'total_correct_answers'
        ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }


}
