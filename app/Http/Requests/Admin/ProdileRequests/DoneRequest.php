<?php

namespace App\Http\Requests\Admin\ProdileRequests;

use Illuminate\Foundation\Http\FormRequest;

class DoneRequest extends FormRequest
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
        $rules = [];
        
        $rules['phone'] = 'array|nullable';
        $rules['phone.value'] = 'string|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/|nullable';
        $rules['phone.status'] = 'in:approved,rejected';
        $rules['phone.comment'] = 'string|nullable';
        $rules['telegram'] = 'array|nullable';
        $rules['telegram.value'] = 'string|nullable';
        $rules['telegram.status'] = 'in:approved,rejected';
        $rules['telegram.comment'] = 'string|nullable';
        $rules['whatsapp'] = 'array|nullable';
        $rules['whatsapp.value'] = 'string|nullable';
        $rules['whatsapp.status'] = 'in:approved,rejected';
        $rules['whatsapp.comment'] = 'string|nullable';
        $rules['snapchat'] = 'array|nullable';
        $rules['snapchat.value'] = 'string|nullable';
        $rules['snapchat.status'] = 'in:approved,rejected';
        $rules['snapchat.comment'] = 'string|nullable';
        $rules['instagram'] = 'array|nullable';
        $rules['instagram.value'] = 'string|nullable';
        $rules['instagram.status'] = 'in:approved,rejected';
        $rules['instagram.comment'] = 'string|nullable';
        $rules['onlyfans'] = 'array|nullable';
        $rules['onlyfans.value'] = 'string|nullable';
        $rules['onlyfans.status'] = 'in:approved,rejected';
        $rules['onlyfans.comment'] = 'string|nullable';
        $rules['profile_email'] = 'array|nullable';
        $rules['profile_email.value'] = 'email|nullable';
        $rules['profile_email.status'] = 'in:approved,rejected';
        $rules['profile_email.comment'] = 'string|nullable';

        $rules['name'] = 'array|nullable';
        $rules['name.value'] = 'string|min:2|max:8|nullable';
        $rules['name.status'] = 'in:approved,rejected';
        $rules['name.comment'] = 'string|nullable';
        $rules['age'] = 'array|nullable';
        $rules['age.value'] = 'integer|min:18|max:100|nullable';
        $rules['age.status'] = 'in:approved,rejected';
        $rules['age.comment'] = 'string|nullable';
        $rules['gender'] = 'array|nullable';
        $rules['gender.value'] = 'in:Man,Woman,LGBTQIA+|nullable';
        $rules['gender.status'] = 'in:approved,rejected';
        $rules['gender.comment'] = 'string|nullable';
        $rules['description'] = 'array|nullable';
        $rules['description.value'] = 'string|min:50|max:150|nullable';
        $rules['description.status'] = 'in:approved,rejected';
        $rules['description.comment'] = 'string|nullable';

        $rules['first_name'] = 'array|nullable';
        $rules['first_name.value'] = 'string|min:2|nullable';
        $rules['first_name.status'] = 'in:approved,rejected';
        $rules['first_name.comment'] = 'string|nullable';
        $rules['last_name'] = 'array|nullable';
        $rules['last_name.value'] = 'string|min:2|nullable';
        $rules['last_name.status'] = 'in:approved,rejected';
        $rules['last_name.comment'] = 'string|nullable';
        $rules['birthday'] = 'array|nullable';
        $rules['birthday.value'] = 'date_format:Y-m-d|nullable';
        $rules['birthday.status'] = 'in:approved,rejected';
        $rules['birthday.comment'] = 'string|nullable';
        $rules['id_photo'] = 'array|nullable';
        $rules['id_photo.value'] = 'exists:images,id|nullable';
        $rules['id_photo.status'] = 'in:approved,rejected';
        $rules['id_photo.comment'] = 'string|nullable';
        $rules['street_photo'] = 'array|nullable';
        $rules['street_photo.value'] = 'exists:images,id|nullable';
        $rules['street_photo.status'] = 'in:approved,rejected';
        $rules['street_photo.comment'] = 'string|nullable';
        $rules['verification_photo'] = 'array|nullable';
        $rules['verification_photo.value'] = 'exists:images,id|nullable';
        $rules['verification_photo.status'] = 'in:approved,rejected';
        $rules['verification_photo.comment'] = 'string|nullable';

        $rules['location'] = 'array|nullable';
        $rules['location.value.zip'] = 'regex:/^[0-9]{5}$/|exists:zip_codes,zip|nullable';
        $rules['location.value.state'] = 'string|nullable';
        $rules['location.value.city'] = 'string|nullable';
        $rules['location.value.street'] = 'string|nullable';
        $rules['location.value.latitude'] = 'between:-90,90|nullable';
        $rules['location.value.longitude'] = 'between:-180,180|nullable';
        $rules['location.status'] = 'in:approved,rejected';
        $rules['location.comment'] = 'string|nullable';

        $rules['photos'] = 'array|nullable';
        $rules['photos.value'] = 'array';
        $rules['photos.value.*'] = 'exists:images,id';
        $rules['photos.status'] = 'array';
        $rules['photos.status.*'] = 'in:approved,rejected';
        $rules['photos.comment'] = 'array';
        $rules['photos.comment.*'] = 'string|nullable';

        return $rules;
    }
}
