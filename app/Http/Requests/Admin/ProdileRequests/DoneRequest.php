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
        
        foreach ([
            'name',
            'gender',
            'phone',
            'description',
            'profile_email',
            'instagram',
            'telegram',
            'snapchat',
            'onlyfans',
            'whatsapp',
            'first_name',
            'last_name',
        ] as $field) {
            $rules[$field] = 'array|nullable';
            $rules["{$field}.value"] = 'string|nullable';
            $rules["{$field}.status"] = 'in:approved,rejected';
            $rules["{$field}.comment"] = 'string|nullable';
            $rules["{$field}.show_rejected"] = 'boolean';
        } 

        $rules['age'] = 'array|nullable';
        $rules['age.value'] = 'integer|nullable';
        $rules['age.status'] = 'in:approved,rejected';
        $rules['age.comment'] = 'string|nullable';
        $rules['age.show_rejected'] = 'boolean';

        $rules['birthday'] = 'array|nullable';
        $rules['birthday.value'] = 'date_format:Y-m-d|nullable';
        $rules['birthday.status'] = 'in:approved,rejected';
        $rules['birthday.comment'] = 'string|nullable';
        $rules['birthday.show_rejected'] = 'boolean';

        $rules['verification_photo'] = 'array|nullable';
        $rules['verification_photo.value'] = 'exists:images,id|nullable';
        $rules['verification_photo.status'] = 'in:approved,rejected';
        $rules['verification_photo.comment'] = 'string|nullable';
        $rules['verification_photo.show_rejected'] = 'boolean';
        $rules['id_photo'] = 'array|nullable';
        $rules['id_photo.value'] = 'exists:images,id|nullable';
        $rules['id_photo.status'] = 'in:approved,rejected';
        $rules['id_photo.comment'] = 'string|nullable';
        $rules['id_photo.show_rejected'] = 'boolean';
        $rules['street_photo'] = 'array|nullable';
        $rules['street_photo.value'] = 'exists:images,id|nullable';
        $rules['street_photo.status'] = 'in:approved,rejected';
        $rules['street_photo.comment'] = 'string|nullable';
        $rules['street_photo.show_rejected'] = 'boolean';

        $rules['location'] = 'array|nullable';
        $rules['location.status'] = 'in:approved,rejected';
        $rules['location.comment'] = 'string|nullable';
        $rules['location.show_rejected'] = 'boolean';
        $rules['location.value.state'] = 'string|nullable';
        $rules['location.value.city'] = 'string|nullable';
        $rules['location.value.first_street'] = 'string|nullable';
        $rules['location.value.second_street'] = 'string|nullable';
        $rules['location.value.latitude'] = 'between:-90,90|nullable';
        $rules['location.value.longitude'] = 'between:-180,180|nullable';

        $rules['photos'] = 'array|nullable';
        $rules['photos.value'] = 'array';
        $rules['photos.value.*'] = 'exists:images,id';
        $rules['photos.status'] = 'array';
        $rules['photos.status.*'] = 'in:approved,rejected';
        $rules['photos.comment'] = 'array';
        $rules['photos.comment.*'] = 'string|nullable';
        $rules['photos.show_rejected'] = 'array';
        $rules['photos.show_rejected.*'] = 'boolean';

        return $rules;
    }
}
