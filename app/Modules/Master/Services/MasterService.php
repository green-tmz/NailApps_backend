<?php

namespace App\Modules\Master\Services;

use App\Modules\Master\Http\Requests\MasterRequest;
use App\Modules\Master\Http\Resources\MasterResource;
use App\Modules\Master\Interfaces\MasterRepositoryInterface;
use App\Modules\Master\Interfaces\MasterServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MasterService implements MasterServiceInterface
{
    private MasterRepositoryInterface $masterRepository;

    public function __construct(MasterRepositoryInterface $masterRepository)
    {
        $this->masterRepository = $masterRepository;
    }

    public function getAllMasters(): AnonymousResourceCollection
    {
        $masters = $this->masterRepository->getAllWithRelations();

        return MasterResource::collection($masters);
    }

    public function createMaster(MasterRequest $request): MasterResource
    {
        $master = $this->masterRepository->create($request->validated());

        return new MasterResource($master);
    }

    public function getMasterById(int $id): MasterResource
    {
        $master = $this->masterRepository->getByIdWithRelations($id);

        return new MasterResource($master);
    }

    public function updateMaster(MasterRequest $request, int $id): MasterResource
    {
        $master = $this->masterRepository->getByIdWithRelations($id);
        $updatedMaster = $this->masterRepository->update($master, $request->validated());

        return new MasterResource($updatedMaster);
    }

    public function deleteMaster(int $id): array
    {
        $master = $this->masterRepository->getByIdWithRelations($id);
        $this->masterRepository->delete($master);

        return ['message' => 'Специализация успешно удалена'];
    }
}
