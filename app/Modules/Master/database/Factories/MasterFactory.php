<?php

namespace App\Modules\Master\Database\Factories;

use App\Modules\Auth\Models\User;
use App\Modules\Master\Models\Master;
use Illuminate\Database\Eloquent\Factories\Factory;

class MasterFactory extends Factory
{
    protected $model = Master::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
        ];
    }
}
