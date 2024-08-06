<?php

namespace App\Http\Requests\Web\Payments;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawSendRequest extends FormRequest
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
            'gateway' => 'required|in:plisio',
            'amount' => 'required|integer',
            
            'currency' => 'required_if:gateway,plisio|in:'.implode(',', config('app.currencies')),
            'to' => 'required_if:gateway,plisio|string',

            'recaptcha' => ['required', new ReCaptchaV3(),],
        ];
    }
}
