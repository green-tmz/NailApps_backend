<?php

namespace App\Modules\Appointment\Http\Controllers;

use App\Modules\Appointment\Http\Requests\AppointmentRequest;
use App\Modules\Appointment\Http\Resources\AppointmentResource;
use App\Modules\Appointment\Models\Appointment;

class AppointmentController
{
    public function index()
    {
        $appointments = Appointment::with(['client.user', 'master.user', 'service'])->get();

        return AppointmentResource::collection($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());

        return new AppointmentResource($appointment->load(['client.user', 'master.user', 'service']));
    }

    public function show(Appointment $appointment)
    {
        return new AppointmentResource($appointment->load(['client.user', 'master.user', 'service']));
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return new AppointmentResource($appointment->load(['client.user', 'master.user', 'service']));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
