<?php

namespace App\Modules\Material\Http\Controllers;

use App\Modules\Material\Http\Requests\MaterialRequest;
use App\Modules\Material\Http\Resources\MaterialResource;
use App\Modules\Material\Models\Material;

class MaterialController
{
    public function index()
    {
        $materials = Material::all();

        return MaterialResource::collection($materials);
    }

    public function store(MaterialRequest $request)
    {
        $material = Material::create($request->validated());

        return new MaterialResource($material);
    }

    public function show(Material $material)
    {
        return new MaterialResource($material);
    }

    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return new MaterialResource($material);
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json(['message' => 'Material deleted successfully']);
    }
}
