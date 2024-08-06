<?php

namespace App\Http\Requests\Web\Settings;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;

class ChangeEmailSendRequest extends FormRequest
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
            'new_email' => 'required|email|unique:creators,email',
            'password' => 'required|current_password:web',
            'recaptcha' => ['required', new ReCaptchaV3(),],
        ];
    }
}
