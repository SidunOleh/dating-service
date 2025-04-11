<?php

namespace App\Http\Requests\Admin\Images;

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
            'image/png',
            'image/webp',
            'image/gif',
            'image/svg+xml',
            'image/SVG',
            'image/heif',
            'image/heif-sequence',
            'image/heic',
            'image/heic-sequence',
            'image/avif',
        ];

        return [
            'img' => 'required|file|mimetypes:' . implode(',', $mimes) . '|max:10240',
            'process' => 'boolean',
        ];
    }
}
