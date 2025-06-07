<?php

namespace App\Policies;

use App\Modules\Auth\Models\User;
use App\Modules\Service\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function view(User $master, Service $service): bool
    {
        return $master->id === $service->user_id;
    }

    public function create(User $master): bool
    {
        return true;
    }

    public function update(User $master, Service $service): bool
    {
        return $master->id === $service->user_id;
    }

    public function delete(User $master, Service $service): bool
    {
        return $master->id === $service->user_id;
    }
}
