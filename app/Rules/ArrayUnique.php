<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayUnique implements Rule
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
        $idArray = [];
        foreach ($value as $item) {
            if (isset($idArray[$item])) {
                $idArray[$item] += 1;
            } else {
                $idArray[$item] = 1;
            }
        }

        foreach ($idArray as $item) {
            if ($item > 1) {
                return false;
            }
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
        return 'Los valores de :attribute no se deben de repetir.';
    }
}
