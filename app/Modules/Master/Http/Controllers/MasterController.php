<?php

namespace App\Modules\Master\Http\Controllers;

use App\Modules\Master\Http\Requests\MasterRequest;
use App\Modules\Master\Http\Resources\MasterResource;
use App\Modules\Master\Interfaces\MasterServiceInterface;
use App\Modules\Master\Models\Master;

class MasterController
{
    private MasterServiceInterface $masterService;

    public function __construct(MasterServiceInterface $masterService)
    {
        $this->masterService = $masterService;
    }

    public function index()
    {
        return $this->masterService->getAllMasters();
    }

    public function store(MasterRequest $request)
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

    public function show(Master $master)
    {
        return new MasterResource($master->load(['user', 'specializations', 'services']));
    }

    public function update(MasterRequest $request, Master $master)
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
