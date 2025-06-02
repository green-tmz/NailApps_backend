<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use App\Modules\Auth\Http\Resources\RegisterResource;
use App\Modules\Auth\Http\Resources\UserResource;
use App\Modules\Auth\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request): RegisterResource
    {
        $validData = $request->validated();

        try {
            DB::beginTransaction();

            $user = $this->authRepository->registerUser($validData);
            $master = $this->authRepository->createMaster($user, $validData['specializationId']);

            DB::commit();

            return new RegisterResource($master);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function login(LoginRequest $request): RegisterResource
    {
        $credentials = $request->only([$request->login_field, 'password']);
        $loginField = $request->login_field;

        $master = $loginField === 'email'
            ? $this->authRepository->findMasterByEmail($credentials['email'])
            : $this->authRepository->findMasterByPhone($credentials['phone']);

        if (!$master || !$this->authRepository->validateCredentials($master, $credentials['password'])) {
            throw ValidationException::withMessages([
                'login' => ['Логин или пароль введены не верно.'],
            ]);
        }

        return new RegisterResource($master);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
