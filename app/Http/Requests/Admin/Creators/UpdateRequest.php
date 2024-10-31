<?php

namespace App\Http\Requests\Admin\Creators;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
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
            'is_banned' => 'boolean',
            'show_on_site' => 'boolean',
            'play_roulette' => 'boolean',

            'email' => [
                'required',
                'email',
                Rule::unique('creators')
                    ->ignore(request()
                        ->route()
                        ->parameter('creator')
                        ->id
                    ),
            ],
            'password' => [
                Password::min(8)->max(32),
            ],

            'photos' => 'array|max:12|nullable',
            'photos.*' => 'exists:images,id',

            'name' => 'string|min:2|max:8|nullable',
            'age' => 'integer|between:21,100|nullable',
            'gender' => 'in:Man,Woman,LGBTQIA+|nullable',
            'description' => 'string|min:250|max:500|nullable',
            
            'phone' => 'string|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/|nullable',
            'telegram' => 'string|nullable',
            'whatsapp' => 'string|nullable',
            'snapchat' => 'string|nullable',
            'instagram' => 'string|nullable',
            'onlyfans' => 'string|nullable',
            'profile_email' => 'email|nullable',

            'zip' => 'regex:/^[0-9]{5}$/|exists:zip_codes,zip|nullable',

            'id_photo' => 'exists:images,id|nullable',
            'street_photo' => 'exists:images,id|nullable',
            'verification_photo' => 'exists:images,id|nullable',
            'first_name' => 'string|min:2|nullable',
            'last_name' => 'string|min:2|nullable',
            'birthday' => 'date_format:Y-m-d|nullable',
        ];
    }
}
