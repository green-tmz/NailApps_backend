<?php

namespace App\Modules\Master\Http\Resources;

use App\Modules\Service\Http\Resources\ServiceResource;
use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            'experience' => $this->experience,
            'description' => $this->description,
            'specializations' => SpecializationResource::collection($this->whenLoaded('specializations')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
