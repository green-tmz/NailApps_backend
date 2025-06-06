<?php

namespace App\Policies;

use App\Modules\Auth\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }
}
