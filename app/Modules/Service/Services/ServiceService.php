<?php

namespace App\Modules\Service\Services;

use App\Modules\Service\Http\Requests\ServiceRequest;
use App\Modules\Service\Http\Resources\ServiceResource;
use App\Modules\Service\Interfaces\ServiceRepositoryInterface;
use App\Modules\Service\Interfaces\ServiceServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ServiceService implements ServiceServiceInterface
{
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
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
        } catch (\Exception $e) {
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
        return new ServiceResource($updateService);
    }

    public function deleteService(int $id): array
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);
        $this->serviceRepository->delete($service);
        return ['message' => 'Услуга успешно удалена'];
    }

    public function getBySpecialization(int $id): AnonymousResourceCollection
    {
        // TODO: Implement getBySpecialization() method.
    }
}
