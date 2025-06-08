<?php

namespace App\Modules\Client\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $phone
 * @property mixed $email
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $second_name
 * @property mixed $birth_date
 * @property mixed $notes
 */
class ClientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'second_name' => $this->second_name,
            'birth_date' => Carbon::parse($this->birth_date)->format("Y-m-d"),
            'notes' => $this->notes,
        ];
    }
}
