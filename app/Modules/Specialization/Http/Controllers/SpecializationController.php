<?php

namespace App\Modules\Specialization\Http\Controllers;

use App\Modules\Specialization\Http\Requests\SpecializationUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use App\Modules\Specialization\Http\Requests\SpecializationRequest;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;

class SpecializationController
{
    public function __construct(private readonly SpecializationServiceInterface $specializationService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->specializationService->getAllSpecializations();
    }

    public function store(SpecializationRequest $request): SpecializationResource
    {
        return $this->specializationService->createSpecialization($request);
    }

    public function show(int $id): SpecializationResource
    {
        return $this->specializationService->getSpecializationById($id);
    }

    public function update(SpecializationUpdateRequest $request, int $id): SpecializationResource
    {
        return $this->specializationService->updateSpecialization($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->specializationService->deleteSpecialization($id);
    }
}
