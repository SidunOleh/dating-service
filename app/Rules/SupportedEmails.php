<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SupportedEmails implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(
            '/@(gmail|outlook|hotmail|yahoo|icloud)\.com$/', 
            $value
        )) {
            $fail('Please use Gmail, Outlook, Hotmail, Yahoo or Apple Mail only.');
        }
    }
}
