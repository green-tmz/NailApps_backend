<?php

namespace App\Modules\Service\Http\Resources;

use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $specialization
 * @property mixed $masters
 * @property mixed $name
 * @property mixed $description
 * @property mixed $duration
 * @property mixed $price
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'specialization' => new SpecializationResource($this->specialization),
            'master' => $this->masters,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_at2' => $this->updated_at,
        ];
    }
}
