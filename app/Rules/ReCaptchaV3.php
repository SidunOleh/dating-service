<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        Log::info('recaptcha', $response->json());

        $data = $response->json();

        if (! $data['success'] or $data['score'] < config('services.recaptcha.score')) {
            $fail('ReCaptchaV3 error.');
        }
    }
}
