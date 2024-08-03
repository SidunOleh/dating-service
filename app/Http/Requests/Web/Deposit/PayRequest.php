<?php

namespace App\Http\Requests\Web\Deposit;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'currency' => 'required|in:',
            // 'amount' => 'required|integer|min:',
            // 'recaptcha' => ['required', new ReCaptchaV3(),],
        ];
    }
}
