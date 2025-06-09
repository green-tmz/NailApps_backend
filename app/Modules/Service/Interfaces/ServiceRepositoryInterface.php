<?php

namespace App\Modules\Service\Interfaces;

use App\Modules\Service\Models\Service;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface
{
    public function getAllWithSpecialization(): Collection;
    public function create(array $data): Service;
    public function attachMaster(Service $service, int $id): Service;
    public function getByIdWithSpecialization(int $id): Service;
    public function update(Service $service, array $data): Service;
    public function delete(Service $service): void;
    public function getBySpecializationId(int $id): Collection;
}
