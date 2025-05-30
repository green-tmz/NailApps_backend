<?php

namespace App\Modules\Specialization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecializationRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:specializations,name',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Специализация с таким названием уже существует',
        ];
    }
}
