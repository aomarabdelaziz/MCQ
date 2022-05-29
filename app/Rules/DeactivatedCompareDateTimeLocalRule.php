<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DeactivatedCompareDateTimeLocalRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $activatedConvertedValue =  strftime('%Y-%m-%dT%H:%M', strtotime(request('activated_at')));
        $deactivatedConvertedValue =  strftime('%Y-%m-%dT%H:%M', strtotime($value));

        if($deactivatedConvertedValue < $activatedConvertedValue) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute period cannot be less than the activated at period.';
    }
}
