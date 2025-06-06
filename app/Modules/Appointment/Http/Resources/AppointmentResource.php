<?php

namespace App\Modules\Appointment\Http\Resources;

use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Master\Http\Resources\MasterResource;
use App\Modules\Service\Http\Resources\ServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $start_time
 * @property mixed $end_time
 * @property mixed $status
 * @property mixed $notes
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class AppointmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'client' => new ClientResource($this->whenLoaded('client')),
            'master' => new MasterResource($this->whenLoaded('master')),
            'service' => new ServiceResource($this->whenLoaded('service')),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
