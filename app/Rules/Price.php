<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Price implements Rule
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
        return preg_match('/^\d+(\.\d{1,2})?$/', $value) && $value >= 0 && $value <= 999999.99;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("validation.price");
    }
}
