<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LatinString implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(
            '/^(?:(?![<>%=])[\p{Latin}\s\d\p{P}\p{S}])*$/', 
            $value
        )) {
            $fail('String has to contain only latin characters.');
        }
    }
}
