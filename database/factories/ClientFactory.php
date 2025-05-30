<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'phone' => '+7' . $this->faker->numerify('##########'),
            'email' => $this->faker->optional()->safeEmail(),
            'preferences' => [
                'favorite_colors' => $this->faker->randomElements(['red', 'pink', 'nude', 'black'], 2),
                'nail_shape' => $this->faker->randomElement(['oval', 'square', 'almond']),
            ],
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function forMaster(User $master): Factory|ClientFactory2
    {
        return $this->state(function (array $attributes) use ($master) {
            return [
                'master_id' => $master->id,
            ];
        });
    }

    public function withEmail(): Factory|ClientFactory2
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->safeEmail(),
            ];
        });
    }

    public function deleted(): Factory|ClientFactory2
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }
}
