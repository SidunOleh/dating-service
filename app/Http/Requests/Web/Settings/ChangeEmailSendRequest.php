<?php

namespace App\Http\Requests\Web\Settings;

use App\Models\Option;
use App\Rules\ReCaptchaV3;
use App\Rules\SupportedEmails;
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
        $settings = Option::getSettings();

        $emailRules = [
            'required',
            'email',
            'unique:creators,email',
        ];

        if ($settings['email_filter']) {
            $emailRules[] = new SupportedEmails;
        }

        return [
            'new_email' => $emailRules,
            'password' => 'required|current_password:web',
        ];
    }
}
