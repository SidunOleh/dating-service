<?php

namespace App\Http\Requests\Web\Profile;

use Illuminate\Foundation\Http\FormRequest;

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
            'phone' => 'required_without_all:telegram,whatsapp|string|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/|nullable',
            'telegram' => 'required_without_all:phone,whatsapp|string|nullable',
            'whatsapp' => 'required_without_all:telegram,phone|string|nullable',
            'snapchat' => 'string|nullable',
            'instagram' => 'string|nullable',
            'onlyfans' => 'string|nullable',
            'profile_email' => 'email|nullable',

            'street' => 'required|string',
            'zip' => 'required|numeric|exists:zip_codes,zip',
            'state' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',

            'name' => 'required|string|min:2|max:8',
            'age' => 'required|integer|between:18,100',
            'gender' => 'string|in:Man,Woman,LGBTQ|nullable',
            'description' => 'required|string|min:50|max:150',

            'photos' => 'required|array|min:1|max:12',
            'photos.*' => 'exists:images,id',

            'id_photo' => 'exists:images,id|nullable',
            'verification_photo' => 'exists:images,id|nullable',
            'street_photo' => 'exists:images,id|nullable',
            'first_name' => 'string|min:2|nullable',
            'last_name' => 'string|min:2|nullable',
            'birthday' => 'date_format:Y-m-d|nullable',
        ];
    }
}
