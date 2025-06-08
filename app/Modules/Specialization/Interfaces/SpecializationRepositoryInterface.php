<?php

namespace App\Modules\Specialization\Interfaces;

use App\Modules\Specialization\Models\Specialization;
use Illuminate\Support\Collection;

interface SpecializationRepositoryInterface
{
    public function getAllWithServices(): Collection;
    public function create(array $data): Specialization;
    public function getById(int $id): Specialization;
    public function update(Specialization $specialization, array $data): Specialization;
    public function delete(Specialization $specialization): void;
}
