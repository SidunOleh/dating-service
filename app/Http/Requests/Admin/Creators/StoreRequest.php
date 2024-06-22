<?php

namespace App\Http\Requests\Admin\Creators;

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
            'email' => 'required|email|unique:creators,email',
            'password' => [
                'required',
                Password::min(8)->max(32),
            ],
            
            'photos' => 'array',
            'photos.*' => 'exists:images,id',
            
            'name' => 'string|nullable',
            'age' => 'integer|between:18,100|nullable',
            'gender' => 'in:Man,Woman,LGBTQ+|nullable',
            'description' => 'string|max:150|nullable',
            
            'phone' => 'string|nullable',
            'profile_email' => 'email|nullable',
            'instagram' => 'string|nullable',
            'telegram' => 'string|nullable',
            'snapchat' => 'string|nullable',
            'onlyfans' => 'string|nullable',
            'whatsapp' => 'string|nullable',

            'full_address' => 'string|nullable',
            'country' => 'string|nullable',
            'region' => 'string|nullable',
            'city' => 'string|nullable',
            'latitude' => 'between:-90,90|nullable',
            'longitude' => 'between:-180,180|nullable',

            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'birthday' => 'date_format:Y-m-d|nullable',
            'verification_photo' => 'exists:images,id|nullable',
            'id_photo' => 'exists:images,id|nullable',
            'street_photo' => 'exists:images,id|nullable',
        ];
    }
}
