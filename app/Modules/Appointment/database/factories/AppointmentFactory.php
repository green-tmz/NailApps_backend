<?php

namespace Database\Factories\Modules\Appointment\Database\Factories;

use App\Models\User;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Client\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('-1 month', '+1 month');

        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'start_time' => $startTime,
            'end_time' => $this->faker->dateTimeBetween($startTime, $startTime->format('Y-m-d H:i:s').' +2 hours'),
            'service' => $this->faker->randomElement([
                'Маникюр + покрытие',
                'Педикюр',
                'Наращивание',
                'Дизайн ногтей',
                'SPA уход'
            ]),
            'price' => $this->faker->numberBetween(500, 3000),
            'notes' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'canceled']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function forMaster(User $master): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) use ($master) {
            return [
                'user_id' => $master->id,
            ];
        });
    }

    public function forClient(Client $client): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) use ($client) {
            return [
                'client_id' => $client->id,
                'master_id' => $client->master_id,
            ];
        });
    }

    public function scheduled(): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'scheduled',
            ];
        });
    }

    public function completed(): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }

    public function canceled(): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'canceled',
            ];
        });
    }

    public function deleted(): AppointmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }
}
