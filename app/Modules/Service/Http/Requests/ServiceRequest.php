<?php

namespace App\Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ServiceRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'masterId' => Auth::user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'specialization_id' => 'required|exists:specializations,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'masterId' => 'nullable|integer|exists:masters,id',
        ];
    }

    public function messages()
    {
        return [
            'specialization_id.required' => 'Поле обязательно для заполнения',
            'specialization_id.exists' => 'Специализация не существует',
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Не верный формат поля',
            'name.max' => 'Длина поля должна быть не больше 255 символов',
            'description.string' => 'Не верный формат поля',
            'duration.required' => 'Поле обязательно для заполнения',
            'duration.integer' => 'Не верный формат поля',
            'duration.min' => 'Значение не может быть меньше 1',
            'price.required' => 'Поле обязательно для заполнения',
            'price.numeric' => 'Не верный формат поля',
            'price.min' => 'Значение не может быть меньше 0',
        ];
    }
}
