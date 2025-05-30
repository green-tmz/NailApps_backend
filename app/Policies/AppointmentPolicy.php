<?php

namespace App\Policies;

use app\Models\User;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }
}
