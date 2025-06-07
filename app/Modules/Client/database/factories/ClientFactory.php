<?php

namespace App\Modules\Client\Database\Factories;

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
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'second_name' => $this->faker->firstName(), // Для отчества
            'birth_date' => $this->faker->date(),
            'notes' => $this->faker->paragraph(),
            'preferences' => json_encode([
                'notification_email' => $this->faker->boolean(),
                'notification_sms' => $this->faker->boolean(),
                'language' => $this->faker->randomElement(['ru', 'en', 'es']),
            ]),
        ];
    }

    /**
     * Состояние для клиента без необязательных полей
     */
    public function minimal(): ClientFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'phone' => null,
            'email' => null,
            'last_name' => null,
            'second_name' => null,
            'birth_date' => null,
            'notes' => null,
            'preferences' => null,
        ]);
    }

    /**
     * Состояние для клиента с конкретным пользователем
     */
    public function forUser(User $user): ClientFactory|Factory
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => $user->id,
        ]);
    }
}
