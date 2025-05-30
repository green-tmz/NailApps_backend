<?php

namespace App\Modules\Specialization\Providers;

use App\Modules\Specialization\Interfaces\SpecializationRepositoryInterface;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;
use App\Modules\Specialization\Repositories\SpecializationRepository;
use App\Modules\Specialization\Services\SpecializationService;
use Illuminate\Support\ServiceProvider;

class SpecializationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SpecializationRepositoryInterface::class, SpecializationRepository::class);
        $this->app->bind(SpecializationServiceInterface::class, SpecializationService::class);
    }
}
