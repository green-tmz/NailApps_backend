<?php

namespace App\Modules\Service\Services;

use Exception;
use App\Modules\Service\Http\Requests\ServiceRequest;
use App\Modules\Service\Http\Resources\ServiceResource;
use App\Modules\Service\Interfaces\ServiceRepositoryInterface;
use App\Modules\Service\Interfaces\ServiceServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class ServiceService implements ServiceServiceInterface
{
    /**
     * @param ServiceRepositoryInterface $serviceRepository
     */
    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    public function getAllServices(): AnonymousResourceCollection
    {
        $services = $this->serviceRepository->getAllWithSpecialization();

        return ServiceResource::collection($services);
    }

    public function createService(ServiceRequest $request): ServiceResource
    {
        $validData = $request->validated();

        try {
            DB::beginTransaction();

            $service = $this->serviceRepository->create($validData);
            $this->serviceRepository->attachMaster($service, $validData['masterId']);
            DB::commit();

            return new ServiceResource($service);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function getServiceById(int $id): ServiceResource
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);

        return new ServiceResource($service);
    }

    public function updateService(ServiceRequest $request, int $id): ServiceResource
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);
        $updateService = $this->serviceRepository->update($service, $request->validated());
        $updateService->load('specialization');

        return new ServiceResource($updateService);
    }

    public function deleteService(int $id): JsonResponse
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);
        if ($service->master->first()->user->id != Auth::user()->id) {
            return response()->json([
                'message' => "Нельзя удалить услугу, так как она не ваша",
                'code' => 403
            ]);
        }
        $this->serviceRepository->delete($service);

        return response()->json([
            'message' => 'Услуга успешно удалена',
            'code' => 200
        ]);
    }

    public function getBySpecializationId(int $id): AnonymousResourceCollection
    {
        $services = $this->serviceRepository->getBySpecializationId($id);

        return ServiceResource::collection($services);
    }
}
