<?php

namespace App\Modules\Specialization\Repositories;

use App\Modules\Specialization\Interfaces\SpecializationRepositoryInterface;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Support\Collection;

class SpecializationRepository implements SpecializationRepositoryInterface
{
    public function getAllWithServices(): Collection
    {
        return Specialization::with('services')->get();
    }

    public function create(array $data): Specialization
    {
        return Specialization::create($data);
    }

    public function getByIdWithServices(int $id): Specialization
    {
        return Specialization::with('services')->findOrFail($id);
    }

    public function update(Specialization $specialization, array $data): Specialization
    {
        $specialization->update($data);

        return $specialization;
    }

    public function delete(Specialization $specialization): void
    {
        $specialization->delete();
    }
}
