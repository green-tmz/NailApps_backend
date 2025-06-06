<?php

namespace App\Modules\Schedule\Http\Controllers;

use App\Modules\Schedule\Http\Requests\ScheduleRequest;
use App\Modules\Schedule\Http\Resources\ScheduleResource;
use App\Modules\Schedule\Models\Schedule;

class ScheduleController
{
    public function index()
    {
        $schedules = Schedule::with('master.user')->get();

        return ScheduleResource::collection($schedules);
    }

    public function store(ScheduleRequest $request): ScheduleResource
    {
        $schedule = Schedule::create($request->validated());

        return new ScheduleResource($schedule->load('master.user'));
    }

    public function show(Schedule $schedule): ScheduleResource
    {
        return new ScheduleResource($schedule->load('master.user'));
    }

    public function update(ScheduleRequest $request, Schedule $schedule): ScheduleResource
    {
        $schedule->update($request->validated());

        return new ScheduleResource($schedule->load('master.user'));
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
