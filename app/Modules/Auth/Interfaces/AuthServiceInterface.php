<?php

namespace App\Modules\Auth\Interfaces;

use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use App\Modules\Auth\Http\Resources\RegisterResource;
use App\Modules\Auth\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
    public function logout(): JsonResponse;
    public function me(): UserResource;
}
