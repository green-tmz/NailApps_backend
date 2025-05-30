<?php

namespace App\Modules\Material\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'min_threshold' => $this->min_threshold,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
