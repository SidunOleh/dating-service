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

            'photos' => 'required|array|min:1|max:12',
            'photos.*' => 'exists:images,id',

            'name' => 'required|string|min:2|max:8',
            'age' => 'required|integer|between:18,100',
            'gender' => 'in:Man,Woman,LGBTQIA+|nullable',
            'description' => 'required|string|min:50|max:150',
            
            'phone' => 'required_without_all:telegram,whatsapp|string|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/|nullable',
            'telegram' => 'required_without_all:phone,whatsapp|string|nullable',
            'whatsapp' => 'required_without_all:phone,telegram|string|nullable',
            'snapchat' => 'string|nullable',
            'instagram' => 'string|nullable',
            'onlyfans' => 'string|nullable',
            'profile_email' => 'email|nullable',

            'zip' => 'required|regex:/^[0-9]{5}$/|exists:zip_codes,zip',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',

            'id_photo' => 'required_with:street_photo,verification_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'street_photo' => 'required_with:id_photo,verification_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'verification_photo' => 'required_with:id_photo,street_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'first_name' => 'required_with:id_photo,street_photo,verification_photo,last_name,birthday|string|min:2|nullable',
            'last_name' => 'required_with:id_photo,street_photo,verification_photo,first_name,birthday|string|min:2|nullable',
            'birthday' => 'required_with:id_photo,street_photo,verification_photo,first_name,last_name|date_format:Y-m-d|nullable',
        ];
    }
}
