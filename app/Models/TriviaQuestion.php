<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =
        [
            'id',
            'exam_id',
            'question',
            'correct_answer',
            'incorrect_answers',
        ];

    protected $casts = [
        'incorrect_answers' => 'array'
    ];
}
