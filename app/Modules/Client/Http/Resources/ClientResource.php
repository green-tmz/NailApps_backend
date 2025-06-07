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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'secondName' => $this->second_name,
            'birthDate' => Carbon::parse($this->birth_date)->format("Y-m-d"),
            'notes' => $this->notes,
        ];
    }
}
