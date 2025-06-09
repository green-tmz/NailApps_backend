<?php

namespace App\Modules\Service\Repositories;

use App\Modules\Service\Interfaces\ServiceRepositoryInterface;
use App\Modules\Service\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function getAllWithSpecialization(): Collection
    {
        return Service::where('master_service.master_id', '=', Auth::user()->id)
            ->join('master_service', 'services.id', '=', 'master_service.service_id')
            ->with(['specialization', 'master.user'])
            ->get();
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function getByIdWithSpecialization(int $id): Service
    {
        return Service::with('specialization')->findOrFail($id);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);

        return $service;
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }

    public function getBySpecializationId(int $id): Collection
    {
        return Service::where('specialization_id', '=', $id)
            ->join('master_service', 'services.id', '=', 'master_service.service_id')
            ->with(['specialization', 'master.user'])
            ->get();
    }

    public function attachMaster(Service $service, int $id): Service
    {
        $service->master()->attach($id);

        return $service;
    }
}
