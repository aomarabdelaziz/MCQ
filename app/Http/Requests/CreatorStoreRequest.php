<?php

namespace App\Http\Requests;

use App\Rules\ActivatedAtTimeLocalRule;
use App\Rules\DateTimeLocalRule;
use App\Rules\DeactivatedCompareDateTimeLocalRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_name' => ['required' , 'string'],
            'activated_at' =>  [ 'required' , new DateTimeLocalRule()],
            'deactivated_at' =>  [ 'required' ,new DateTimeLocalRule() , new DeactivatedCompareDateTimeLocalRule() ],
            'number_of_questions' => ['numeric' , 'min:1' , 'max:50'],
            'trivia_category' => ['sometimes','required' ],
            'trivia_difficulty' => ['sometimes','required'],
            'trivia_type' =>  ['sometimes','required' ],
        ];
    }
}
