<?php

namespace App\Http\Requests\Web\Settings;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required|current_password:web',
            'new_password' => [
                'required', 
                Password::min(8)->max(32),
            ],
            'recaptcha' => ['required', new ReCaptchaV3(),],
        ];
    }
}
