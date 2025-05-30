<?php

namespace App\Modules\Master\Interfaces;

use App\Modules\Master\Http\Requests\MasterRequest;
use App\Modules\Master\Http\Resources\MasterResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface MasterServiceInterface
{
    public function getAllMasters(): AnonymousResourceCollection;
    public function createMaster(MasterRequest $request): MasterResource;
    public function getMasterById(int $id): MasterResource;
    public function updateMaster(MasterRequest $request, int $id): MasterResource;
    public function deleteMaster(int $id): array;
}
