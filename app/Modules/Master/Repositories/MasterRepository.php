<?php

namespace App\Modules\Master\Repositories;

use App\Modules\Master\Interfaces\MasterRepositoryInterface;
use App\Modules\Master\Models\Master;
use Illuminate\Support\Collection;

class MasterRepository implements MasterRepositoryInterface
{
    public function getAllWithRelations(): Collection
    {
        return Master::with(['user', 'specializations', 'services'])->get();
    }

    public function create(array $data): Master
    {
        return Master::create($data);
    }

    public function getByIdWithRelations(int $id): Master
    {
        return Master::with(['user', 'specializations', 'services'])->findOrFail($id);
    }

    public function update(Master $master, array $data): Master
    {
        $master->update($data);

        return $master;
    }

    public function delete(Master $master): void
    {
        $master->delete();
    }
}
