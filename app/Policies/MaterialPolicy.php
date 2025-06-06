<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Material\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }

    public function delete(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }
}
