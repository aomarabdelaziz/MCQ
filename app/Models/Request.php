<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'exam_id',
        'access',
    ];

    protected $casts = [
        'access' => 'boolean'
    ];



    public function exams()
    {
        return $this->belongsTo(Exam::class , 'exam_id');

    }


}
