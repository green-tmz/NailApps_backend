<?php

namespace App\Modules\Service\Database\Factories;

use App\Modules\Service\Models\Service;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'specialization_id' => Specialization::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'duration' => $this->faker->numberBetween(15, 120),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
