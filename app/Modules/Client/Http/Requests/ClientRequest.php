<?php

namespace App\Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'preferences' => 'nullable|json',
        ];
    }
}
