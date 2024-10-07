<?php

namespace App\Rules;

use App\Models\Template;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfileBlocksCount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $templates = Template::all();

        if ($templates->count() > 0) {
            $count = $templates[0]->count('profile');

            $blocksCount = array_count_values($value);
            $profileCount = $blocksCount['profile'] ?? 0;

            if ($count != $profileCount) {
                $fail('Templates must have the same count of profile blocks.');
            }
        } 
    }
}
