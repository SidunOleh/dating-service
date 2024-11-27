<?php

namespace App\Http\Requests\Web\Profile;

use App\Rules\ReCaptchaV3;
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
            'phone' => 'required_without_all:telegram,whatsapp,snapchat,instagram,onlyfans,profile_email|string|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/|nullable',
            'telegram' => 'required_without_all:phone,whatsapp,snapchat,instagram,onlyfans,profile_email|string|nullable',
            'whatsapp' => 'required_without_all:phone,telegram,snapchat,instagram,onlyfans,profile_email|string|nullable',
            'snapchat' => 'required_without_all:phone,telegram,whatsapp,instagram,onlyfans,profile_email|string|nullable',
            'instagram' => 'required_without_all:phone,telegram,whatsapp,snapchat,onlyfans,profile_email|string|nullable',
            'onlyfans' => 'required_without_all:phone,telegram,whatsapp,snapchat,instagram,profile_email|string|nullable',
            'profile_email' => 'required_without_all:phone,telegram,whatsapp,snapchat,instagram,onlyfans|email|nullable',

            'zip' => 'required|regex:/^[0-9]{5}$/|exists:zip_codes,zip',

            'name' => 'required|string|min:2|max:12',
            'age' => 'required|integer|between:21,100',
            'gender' => 'in:Man,Woman,LGBTQIA+|nullable',
            'description' => 'required|string|min:250|max:500',

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
            'phone.required_without_all' => 'One from contact fields required',
            'phone.regex' => 'Invalid format',
            'telegram.required_without_all' => 'One from contact fields required',
            'whatsapp.required_without_all' => 'One from contact fields required',
            'snapchat.required_without_all' => 'One from contact fields required',
            'instagram.required_without_all' => 'One from contact fields required',
            'onlyfans.required_without_all' => 'One from contact fields required',
            'profile_email.required_without_all' => 'One from contact fields required',
            'profile_email.email' => 'Invalid format',

            'street.required' => 'Street required',
            'zip.required' => 'ZIP Code required',
            'zip.regex' => 'ZIP Code invalid',
            'zip.exists' => 'ZIP Code Not Found',

            'name.required' => 'Name required',
            'name.min' => 'At least 2 letters',
            'name.max' => 'Up to 12 letters',
            'age.required' => 'Age required',
            'age.integer' => 'Inalid age',
            'age.min' => 'Must be 21+',
            'age.max' => 'Maximum age 100',
            'description.required' => 'Description required',
            'description.min' => 'Must be 250-500 words',
            'description.max' => 'Must be 250-500 words',
            
            'photos.required' => 'Photo required',

            'id_photo.required_with' => 'Photo required',
            'street_photo.required_with' => 'Photo required',
            'verification_photo.required_with' => 'Photo required',
            'first_name.required_with' => 'First name required',
            'first_name.min' => 'At least 2 letters',
            'last_name.required_with' => 'Last name required',
            'last_name.min' => 'At least 2 letters',
            'birthday.required_with' => 'Birthday required',
        ];
    }
}
