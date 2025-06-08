<?php

namespace App\Modules\Specialization\Services;

use App\Modules\Specialization\Http\Requests\SpecializationRequest;
use App\Modules\Specialization\Http\Requests\SpecializationUpdateRequest;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use App\Modules\Specialization\Interfaces\SpecializationRepositoryInterface;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

readonly class SpecializationService implements SpecializationServiceInterface
{
    public function __construct(private SpecializationRepositoryInterface $specializationRepository)
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
        $specialization = $this->specializationRepository->getById($id);

        return new SpecializationResource($specialization);
    }

    public function updateSpecialization(SpecializationUpdateRequest|SpecializationRequest $request, int $id): SpecializationResource
    {
        $specialization = $this->specializationRepository->getById($id);
        $updatedSpecialization = $this->specializationRepository->update($specialization, $request->validated());

        return new SpecializationResource($updatedSpecialization);
    }

    public function deleteSpecialization(int $id): JsonResponse
    {
        $specialization = $this->specializationRepository->getById($id);
        $masterIds = $specialization->masters->pluck('id')->toArray();
        if (count($masterIds) > 0) {
            return response()->json([
                'message' => "Нельзя удалить специализацию, так как с ней связаны мастера",
                'code' => 409
            ]);
        }
        $this->specializationRepository->delete($specialization);

        return response()->json([
            'message' => 'Специализация успешно удалена',
            'code' => 200
        ]);
    }
}
