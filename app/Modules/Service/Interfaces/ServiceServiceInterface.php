<?php

namespace App\Modules\Service\Interfaces;

use App\Modules\Service\Http\Requests\ServiceRequest;
use App\Modules\Service\Http\Resources\ServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ServiceServiceInterface
{
    public function getAllServices(): AnonymousResourceCollection;
    public function createService(ServiceRequest $request): ServiceResource;
    public function getServiceById(int $id): ServiceResource;
    public function updateService(ServiceRequest $request, int $id): ServiceResource;
    public function deleteService(int $id): JsonResponse;
    public function getBySpecializationId(int $id): AnonymousResourceCollection;
}
