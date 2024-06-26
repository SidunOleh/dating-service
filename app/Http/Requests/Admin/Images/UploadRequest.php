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
        return [
            'img' => 'required|file|extensions:jpg,png,webp,gif,heic,heif,svg|size:10240',
            'watermark' => 'boolean',
            'quality' => 'integer|between:0,100|nullable',
        ];
    }
}
