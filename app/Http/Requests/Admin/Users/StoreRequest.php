<?php

namespace App\Http\Requests\Admin\Users;

use App\Rules\TimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|exists:roles,name',
            'password' => [
                'required',
                Password::min(8)->max(32),
            ],
        ];
    }
}
