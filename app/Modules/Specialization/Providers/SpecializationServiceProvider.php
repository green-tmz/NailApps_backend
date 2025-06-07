<?php

namespace App\Modules\Specialization\Providers;

use App\Modules\Specialization\Interfaces\SpecializationRepositoryInterface;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;
use App\Modules\Specialization\Repositories\SpecializationRepository;
use App\Modules\Specialization\Services\SpecializationService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class SpecializationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function ($modelName) {
            if (str_starts_with($modelName, 'App\Modules\Specialization\Models\\')) {
                $moduleName = 'Specialization';
                $modelName = str_replace('App\Modules\\'.$moduleName.'\Models\\', '', $modelName);

                return 'App\Modules\\'.$moduleName.'\Database\Factories\\'.$modelName.'Factory';
            }
        });
    }

    public function register(): void
    {
        $this->app->bind(SpecializationRepositoryInterface::class, SpecializationRepository::class);
        $this->app->bind(SpecializationServiceInterface::class, SpecializationService::class);
    }
}
