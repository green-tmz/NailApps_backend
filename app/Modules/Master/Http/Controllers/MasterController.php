<?php

namespace App\Modules\Master\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Modules\Master\Http\Requests\MasterRequest;
use App\Modules\Master\Http\Resources\MasterResource;
use App\Modules\Master\Interfaces\MasterServiceInterface;
use App\Modules\Master\Models\Master;

class MasterController
{
    public function __construct(private readonly MasterServiceInterface $masterService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->masterService->getAllMasters();
    }

    public function store(MasterRequest $request): MasterResource
    {
        $master = Master::create($request->validated());

        if ($request->has('specializations')) {
            $master->specializations()->sync($request->specializations);
        }

        if ($request->has('services')) {
            $master->services()->sync($request->services);
        }

        return new MasterResource($master->load(['user', 'specializations', 'services']));
    }

    public function show(Master $master): MasterResource
    {
        return new MasterResource($master->load(['user', 'specializations', 'services']));
    }

    public function update(MasterRequest $request, Master $master): MasterResource
    {
        $master->update($request->validated());

        if ($request->has('specializations')) {
            $master->specializations()->sync($request->specializations);
        }

        if ($request->has('services')) {
            $master->services()->sync($request->services);
        }

        return new MasterResource($master->load(['user', 'specializations', 'services']));
    }

    public function destroy(Master $master)
    {
        $master->delete();

        return response()->json(['message' => 'Master deleted successfully']);
    }
}
