<?php

namespace App\Modules\Specialization\Http\Resources;

use App\Modules\Service\Http\Resources\ServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 */
class SpecializationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
