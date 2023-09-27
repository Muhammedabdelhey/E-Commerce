<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArrayLengthRule implements ValidationRule
{
    protected $otherField;

    public function __construct($otherField)
    {
        $this->otherField = $otherField;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $otherValue = request()->input($this->otherField);
        if(count($value)!== count($otherValue)){
            $fail("you should select ".$attribute." for all Products");
        }
    }
}
