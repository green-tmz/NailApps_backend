<?php

namespace App\Modules\Service\Http\Resources;

use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $specialization
 * @property mixed $name
 * @property mixed $description
 * @property mixed $duration
 * @property mixed $price
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $master
 */
class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $master = $this->master->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'specialization' => new SpecializationResource($this->specialization),
            'master' => [
                'id' => $master->user->id,
                'first_name' => $master->user->first_name,
                'last_name' => $master->user->last_name,
                'second_name' => $master->user->second_name,
                'phone' => $master->user->phone,
                'email' => $master->user->email,
            ]
        ];
    }
}
