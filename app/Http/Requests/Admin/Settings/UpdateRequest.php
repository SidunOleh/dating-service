<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

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
            'show_top_ad' => 'required|boolean',
            'clicks_between_popups' => 'required|integer|gte:1',
            'seconds_between_popups' => 'required|integer|gte:1',
            'close_popup_seconds' => 'required|integer|gte:1',
            'referral_percent' => 'required|integer|between:0,100',
        ];
    }
}
