<?php

namespace App\Modules\Service\Providers;

use App\Modules\Service\Interfaces\ServiceRepositoryInterface;
use App\Modules\Service\Interfaces\ServiceServiceInterface;
use App\Modules\Service\Repositories\ServiceRepository;
use App\Modules\Service\Services\ServiceService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);
    }
}
