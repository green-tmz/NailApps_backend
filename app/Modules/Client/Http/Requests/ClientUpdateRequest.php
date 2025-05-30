<?php

namespace App\Modules\Client\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientUpdateRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::user()->id
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'preferences' => 'nullable|json',
        ];
    }
}
