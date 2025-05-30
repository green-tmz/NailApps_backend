<?php

namespace App\Modules\Appointment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'master_id' => 'required|exists:masters,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|string|in:scheduled,completed,canceled',
            'notes' => 'nullable|string',
        ];
    }
}
