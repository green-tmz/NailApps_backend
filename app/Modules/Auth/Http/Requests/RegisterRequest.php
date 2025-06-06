<?php

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $second_name
 */
class RegisterRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'second_name' => $this->second_name ? trim((string) $this->second_name) : null,
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string|unique:users',
            'password' => 'required|min:8|confirmed',
            'specializationId' => 'required|array|exists:specializations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Поле обязательно для заполнения',
            'first_name.string' => 'Поле должно быть строкой',
            'first_name.max' => 'Поле долно содержать максимум 50 символов',
            'last_name.required' => 'Поле обязательно для заполнения',
            'last_name.string' => 'Поле должно быть строкой',
            'last_name.max' => 'Поле долно содержать максимум 50 символов',
            'second_name.string' => 'Поле должно быть строкой',
            'second_name.max' => 'Поле долно содержать максимум 50 символов',
            'email.email' => 'Не верный формат поля',
            'email.unique' => 'Пользователь с таким email уже существует',
            'phone.string' => 'Не верный формат поля',
            'phone.unique' => 'Пользователь с таким телефоном уже существует',
            'password.min' => 'Пароль должен содержать не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'specializationId.required' => 'Поле обязательно для заполнения',
            'specializationId.array' => 'Поле должно быть числом',
            'specializationId.exists' => 'Специализация не существует',
        ];
    }
}
