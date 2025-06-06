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

    /**
     * @param ServiceRepositoryInterface $serviceRepository
     */
    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllServices(): AnonymousResourceCollection
    {
        $services = $this->serviceRepository->getAllWithSpecialization();

        return ServiceResource::collection($services);
    }

    /**
     * @param ServiceRequest $request
     * @return ServiceResource
     * @throws \Exception
     */
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

    /**
     * @param int $id
     * @return ServiceResource
     */
    public function getServiceById(int $id): ServiceResource
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);

        return new ServiceResource($service);
    }

    /**
     * @param ServiceRequest $request
     * @param int $id
     * @return ServiceResource
     */
    public function updateService(ServiceRequest $request, int $id): ServiceResource
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);
        $updateService = $this->serviceRepository->update($service, $request->validated());
        $updateService->load('specialization');

        return new ServiceResource($updateService);
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function deleteService(int $id): array
    {
        $service = $this->serviceRepository->getByIdWithSpecialization($id);
        $this->serviceRepository->delete($service);

        return ['message' => 'Услуга успешно удалена'];
    }

    /**
     * @param int $id
     * @return void
     */
    public function getBySpecialization(int $id): void
    {
        // TODO: Implement getBySpecialization() method.
    }
}
