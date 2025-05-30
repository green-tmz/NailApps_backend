<?php

namespace App\Modules\Service\Repositories;

use App\Modules\Service\Interfaces\ServiceRepositoryInterface;
use App\Modules\Service\Models\Service;
use Illuminate\Support\Collection;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function getAllWithSpecialization(): Collection
    {
        return Service::with('specialization')->get();
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

    public function getBySpecialization(int $id)
    {
        // TODO: реализовать связь
    }

    public function attachMaster(Service $service, int $id): Service
    {
        $service->masters()->attach($id);
        return $service;
    }
}
