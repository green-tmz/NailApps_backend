<?php

namespace App\Modules\Service\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Modules\Service\Http\Resources\ServiceResource;
use App\Modules\Service\Http\Requests\ServiceRequest;
use App\Modules\Service\Interfaces\ServiceServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController
{
    use AuthorizesRequests;

    public function __construct(private ServiceServiceInterface $serviceService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->serviceService->getAllServices();
    }

    public function store(ServiceRequest $request): ServiceResource
    {
        return $this->serviceService->createService($request);
    }

    public function show(int $id): ServiceResource
    {
        return $this->serviceService->getServiceById($id);
    }

    public function update(ServiceRequest $request, int $id): ServiceResource
    {
        return $this->serviceService->updateService($request, $id);
    }

    public function destroy(int $id): array
    {
        return $this->serviceService->deleteService($id);
    }

    public function getBySpecialization(int $id): void
    {
    }
}
