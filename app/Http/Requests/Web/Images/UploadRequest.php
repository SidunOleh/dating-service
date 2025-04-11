<?php

namespace App\Http\Requests\Web\Images;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
        $mimes = [
            'image/jpeg',
            'image/webp',
            'image/heif',
            'image/heif-sequence',
            'image/heic',
            'image/heic-sequence',
            'image/avif',
        ];

        return [
            'img' => 'required|file|mimetypes:' . implode(',', $mimes) . '|min:10|max:10240',
        ];
    }
}
