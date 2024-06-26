<?php

namespace App\Http\Requests\Admin\Ads;

use App\Rules\LatinString;
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
            'image_id' => 'required|exists:images,id', 
            'name' => [
                'required',
                'string',
                'unique:ads,name',
                new LatinString,
            ],
            'link' => 'required|url', 
            'clicks_limit' => 'required|integer|gte:1', 
            'type' => 'required|in:block,popup', 
        ];
    }
}
