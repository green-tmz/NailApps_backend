<?php

namespace App\Modules\Specialization\Services;

use App\Modules\Specialization\Http\Requests\SpecializationRequest;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use App\Modules\Specialization\Interfaces\SpecializationRepositoryInterface;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SpecializationService implements SpecializationServiceInterface
{
    public function __construct(private readonly SpecializationRepositoryInterface $specializationRepository)
    {
    }

    public function getAllSpecializations(): AnonymousResourceCollection
    {
        $specializations = $this->specializationRepository->getAllWithServices();

        return SpecializationResource::collection($specializations);
    }

    public function createSpecialization(SpecializationRequest $request): SpecializationResource
    {
        $specialization = $this->specializationRepository->create($request->validated());

        return new SpecializationResource($specialization);
    }

    public function getSpecializationById(int $id): SpecializationResource
    {
        $specialization = $this->specializationRepository->getByIdWithServices($id);

        return new SpecializationResource($specialization);
    }

    public function updateSpecialization(SpecializationRequest $request, int $id): SpecializationResource
    {
        $specialization = $this->specializationRepository->getByIdWithServices($id);
        $updatedSpecialization = $this->specializationRepository->update($specialization, $request->validated());

        return new SpecializationResource($updatedSpecialization);
    }

    public function deleteSpecialization(int $id): array
    {
        $specialization = $this->specializationRepository->getByIdWithServices($id);
        $this->specializationRepository->delete($specialization);

        return ['message' => 'Специализация успешно удалена'];
    }
}
