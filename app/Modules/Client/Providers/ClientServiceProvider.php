<?php

namespace App\Modules\Client\Providers;

use App\Modules\Client\Interfaces\ClientRepositoryInterface;
use App\Modules\Client\Interfaces\ClientServiceInterface;
use App\Modules\Client\Repositories\ClientRepository;
use App\Modules\Client\Services\ClientService;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
    }
}
