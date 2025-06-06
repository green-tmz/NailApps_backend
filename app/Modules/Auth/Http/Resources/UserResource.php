<?php

namespace App\Modules\Auth\Http\Resources;

use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $second_name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $master
 * @method getRoleNames()
 * @method getAllPermissions()
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'first_name' => $this->first_name,
            "last_name" => $this->last_name,
            "second_name" => $this->second_name,
            "email" => $this->email,
            "phone" => $this->phone,
            'role' => $this->getRoleNames()->first(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'specialization' => SpecializationResource::collection($this->master->specializations),
        ];
    }
}
