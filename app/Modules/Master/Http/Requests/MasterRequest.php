<?php

namespace App\Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'experience' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ];
    }
}
