<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReCaptchaV3 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
        ]);

        if (! $response->ok()) {
            $fail($response->getReasonPhrase());
        }

        $data = $response->json();

        if (! $data['success'] and $data['error-codes'][0] == 'browser-error') {
            return;
        }

        if (! $data['success'] or $data['score'] < config('services.recaptcha.score')) {
            $fail('ReCaptchaV3 error.');
        }
    }
}
