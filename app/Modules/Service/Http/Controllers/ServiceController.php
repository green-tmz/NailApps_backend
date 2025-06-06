<?php

namespace App\Modules\Service\Http\Controllers;

use App\Modules\Service\Http\Requests\ServiceRequest;
use App\Modules\Service\Interfaces\ServiceServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController
{
    use AuthorizesRequests;

    private ServiceServiceInterface $serviceService;

    public function __construct(ServiceServiceInterface $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        return $this->serviceService->getAllServices();
    }

    public function store(ServiceRequest $request)
    {
        return $this->serviceService->createService($request);
    }

    public function show(int $id)
    {
        return$this->serviceService->getServiceById($id);
    }

    public function update(ServiceRequest $request, int $id)
    {
        return $this->serviceService->updateService($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->serviceService->deleteService($id);
    }

    public function getBySpecialization(int $id): void
    {
        return;
    }
}
