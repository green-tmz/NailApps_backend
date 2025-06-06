<?php

namespace App\Modules\Schedule\Http\Resources;

use App\Modules\Master\Http\Resources\MasterResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $day_of_week
 * @property mixed $start_time
 * @property mixed $end_time
 * @property mixed $is_working
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ScheduleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'master' => new MasterResource($this->whenLoaded('master')),
            'day_of_week' => $this->day_of_week,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_working' => $this->is_working,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
