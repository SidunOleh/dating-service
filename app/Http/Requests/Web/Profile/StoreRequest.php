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
            'whatsapp' => 'required_without_all:phone,telegram|string|nullable',
            'snapchat' => 'string|nullable',
            'instagram' => 'string|nullable',
            'onlyfans' => 'string|nullable',
            'profile_email' => 'email|nullable',

            'street' => 'required|string',
            'zip' => 'required|regex:/^[0-9]{5}$/||exists:zip_codes,zip',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',

            'name' => 'required|string|min:2|max:8',
            'age' => 'required|integer|between:18,100',
            'gender' => 'in:Man,Woman,LGBTQIA+|nullable',
            'description' => 'required|string|min:50|max:150',

            'photos' => 'required|array|min:1|max:12',
            'photos.*' => 'exists:images,id',

            'id_photo' => 'required_with:street_photo,verification_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'street_photo' => 'required_with:id_photo,verification_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'verification_photo' => 'required_with:id_photo,street_photo,first_name,last_name,birthday|exists:images,id|nullable',
            'first_name' => 'required_with:id_photo,street_photo,verification_photo,last_name,birthday|string|min:2|nullable',
            'last_name' => 'required_with:id_photo,street_photo,verification_photo,first_name,birthday|string|min:2|nullable',
            'birthday' => 'required_with:id_photo,street_photo,verification_photo,first_name,last_name|date_format:Y-m-d|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required_without_all' => 'One from Phone, Telegram, Whatsapp fields required',
            'phone.regex' => 'Invalid format',
            'telegram.required_without_all' => 'One from Phone, Telegram, Whatsapp fields required',
            'whatsapp.required_without_all' => 'One from Phone, Telegram, Whatsapp fields required',
            'prfofile_email.email' => 'Invalid format',

            'street.required' => 'Street required',
            'zip.required' => 'Zip Code required',
            'zip.regex' => 'Zip Code invalid',
            'zip.exists' => 'Zip Code Not Found',

            'name.required' => 'Name required',
            'name.min' => 'At least 2 letters',
            'name.max' => 'Up to 8 letters',
            'age.required' => 'Age required',
            'age.integer' => 'Inalid age',
            'age.min' => 'Must be 18+',
            'age.max' => 'Maximum age 100',
            'description.required' => 'Description required',
            'description.min' => 'Must be 50-150 words',
            'description.max' => 'Must be 50-150 words',
            
            'first_name.required_with' => 'Name required',
            'first_name.min' => 'At least 2 letters',
            'last_name.required_with' => 'Name required',
            'last_name.min' => 'At least 2 letters',
            'birthday.required_with' => 'Birthday required',
        ];
    }
}
