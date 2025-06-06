<?php

namespace App\Modules\Auth\Interfaces;

use App\Modules\Auth\Models\User;
use App\Modules\Master\Models\Master;

interface AuthRepositoryInterface
{
    public function registerUser(array $userData): User;
    public function createMaster(User $user, int $specializationId): Master;
    public function findMasterByEmail(string $email): ?Master;
    public function findMasterByPhone(string $phone): ?Master;
    public function validateCredentials(Master $master, string $password): bool;
}
