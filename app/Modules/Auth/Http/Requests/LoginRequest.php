<?php

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $login = $this->input('login');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : (preg_match('/^[\d\+\(\)\s-]+$/', (string) $login) ? 'phone' : 'name');

        $this->merge([
            $field => $login,
            'login_field' => $field,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'Поле обязательно для заполнения',
            'login.string' => 'Поле должно быть строкой',
            'password.required' => 'Поле обязательно для заполнения',
            'password.string' => 'Поле должно быть строкой',
        ];
    }
}
