<?php

namespace App\Modules\Service\Http\Resources;

use App\Modules\Master\Http\Resources\MasterResource;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'specialization' => new SpecializationResource($this->whenLoaded('specialization')),
            'master' => $this->masters,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
