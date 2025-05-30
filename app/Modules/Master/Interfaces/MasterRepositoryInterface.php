<?php

namespace App\Modules\Master\Interfaces;

use App\Modules\Master\Models\Master;
use Illuminate\Support\Collection;

interface MasterRepositoryInterface
{
    public function getAllWithRelations(): Collection;
    public function create(array $data): Master;
    public function getByIdWithRelations(int $id): Master;
    public function update(Master $master, array $data): Master;
    public function delete(Master $master): void;
}
