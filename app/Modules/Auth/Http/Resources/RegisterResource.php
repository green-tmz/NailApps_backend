<?php

namespace App\Modules\Auth\Http\Resources;

use App\Modules\Specialization\Http\Resources\SpecializationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->user->createToken('api-token')->plainTextToken,
            'master' => [
                "id" => $this->id,
                'first_name' => $this->user->first_name,
                "last_name" => $this->user->last_name,
                "second_name" => $this->user->second_name,
                "email" => $this->user->email,
                "phone" => $this->user->phone,
            ],
            'specialization' => SpecializationResource::collection($this->specializations)
        ];
    }
}
