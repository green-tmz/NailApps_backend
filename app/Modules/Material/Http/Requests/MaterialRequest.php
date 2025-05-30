<?php

namespace App\Modules\Material\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'min_threshold' => 'nullable|integer|min:0',
        ];
    }
}
