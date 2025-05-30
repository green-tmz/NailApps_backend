<?php

namespace App\Modules\Client\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'second_name' => $this->second_name,
            'birth_date' => $this->birth_date,
            'preferences' => $this->preferences,
            'created_at' => Carbon::parse($this->created_at)->format("d.m.Y"),
            'updated_at' => Carbon::parse($this->updated_at)->format("d.m.Y"),
        ];
    }
}
