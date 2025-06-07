<?php

namespace Database\Factories\Modules\Material\Database\Factories;

use App\Modules\Auth\Models\User;
use App\Modules\Material\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'category' => $this->faker->randomElement(['nail', 'pedicure', 'disinfection', 'other']),
            'quantity' => $this->faker->randomFloat(2, 0, 1000),
            'unit' => $this->faker->randomElement(['pcs', 'ml', 'g', 'pack']),
            'cost' => $this->faker->randomFloat(2, 10, 5000),
            'alert_level' => $this->faker->optional()->randomFloat(2, 1, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function forMaster(User $master): MaterialFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'master_id' => $master->id,
        ]);
    }

    public function nailCategory(): MaterialFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'category' => 'nail',
        ]);
    }

    public function lowQuantity(): MaterialFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'quantity' => $this->faker->numberBetween(1, 5),
            'alert_level' => 10,
        ]);
    }

    public function deleted(): MaterialFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'deleted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
