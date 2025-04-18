<?php

namespace App\Http\Requests\Web\Posts;

use App\Constants\Uploads;
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
            'images' => 'required|array|min:1|max:3',
            'images.*' => 'required|file|mimetypes:' . implode(',', Uploads::IMAGE_MIME_TYPES) . '|min:10|max:10240',
            'text' => 'string|max:150|nullable',
            'button_number' => 'required|in:1,2,3',
        ];
    }
}
