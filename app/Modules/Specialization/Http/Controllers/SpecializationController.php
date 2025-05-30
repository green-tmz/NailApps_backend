<?php

namespace App\Modules\Specialization\Http\Controllers;

use App\Modules\Specialization\Http\Requests\SpecializationRequest;
use App\Modules\Specialization\Interfaces\SpecializationServiceInterface;

class SpecializationController
{
    private SpecializationServiceInterface $specializationService;

    public function __construct(SpecializationServiceInterface $specializationService)
    {
        $this->specializationService = $specializationService;
    }

    public function index()
    {
        return $this->specializationService->getAllSpecializations();
    }

    public function store(SpecializationRequest $request)
    {
        return $this->specializationService->createSpecialization($request);
    }

    public function show(int $id)
    {
        return $this->specializationService->getSpecializationById($id);
    }

    public function update(SpecializationRequest $request, int $id)
    {
        return $this->specializationService->updateSpecialization($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->specializationService->deleteSpecialization($id);
    }
}
