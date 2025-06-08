<?php

namespace App\Modules\Specialization\Interfaces;

use App\Modules\Specialization\Http\Requests\SpecializationRequest;
use App\Modules\Specialization\Http\Requests\SpecializationUpdateRequest;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface SpecializationServiceInterface
{
    public function getAllSpecializations(): AnonymousResourceCollection;
    public function createSpecialization(SpecializationRequest $request): SpecializationResource;
    public function getSpecializationById(int $id): SpecializationResource;
    public function updateSpecialization(SpecializationUpdateRequest $request, int $id): SpecializationResource;
    public function deleteSpecialization(int $id): JsonResponse;
}
