<?php

namespace App\Modules\Specialization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecializationUpdateRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
