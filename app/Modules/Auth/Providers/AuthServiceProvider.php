<?php

namespace App\Modules\Auth\Providers;

use App\Modules\Auth\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Interfaces\AuthServiceInterface;
use App\Modules\Auth\Repositories\AuthRepository;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
}
