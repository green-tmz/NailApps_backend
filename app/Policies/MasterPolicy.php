<?php

namespace App\Policies;

use App\Modules\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $master): bool
    {
        return $user->id === $master->id;
    }

    public function update(User $user, User $master): bool
    {
        return $user->id === $master->id;
    }

    public function delete(User $user, User $master): bool
    {
        return $user->id === $master->id;
    }
}
