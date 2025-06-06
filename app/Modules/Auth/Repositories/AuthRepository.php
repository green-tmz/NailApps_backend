<?php

namespace App\Modules\Auth\Repositories;

use App\Modules\Auth\Models\User;
use App\Modules\Auth\Interfaces\AuthRepositoryInterface;
use App\Modules\Master\Models\Master;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function registerUser(array $userData): User
    {
        return User::create([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'second_name' => $userData['second_name'],
            'email' => ($userData['email']) ?? null,
            'phone' => $userData['phone'] ?? null,
            'password' => Hash::make($userData['password']),
        ]);
    }

    public function createMaster(User $user, array|int $specializationId): Master
    {
        $user->assignRole('master');

        $master = Master::create(['user_id' => $user->id]);
        $master->specializations()->attach($specializationId);

        return $master;
    }

    public function findMasterByEmail(string $email): ?Master
    {
        return Master::join('users', 'masters.user_id', '=', 'users.id')
            ->where('users.email', $email)
            ->with(['specializations', 'user'])
            ->first();
    }

    public function findMasterByPhone(string $phone): ?Master
    {
        return Master::join('users', 'masters.user_id', '=', 'users.id')
            ->where('users.phone', $phone)
            ->with(['specializations', 'user'])
            ->first();
    }

    public function validateCredentials(Master $master, string $password): bool
    {
        return Hash::check($password, $master->user->password);
    }
}
