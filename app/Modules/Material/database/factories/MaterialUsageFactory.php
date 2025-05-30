<?php

namespace Database\Factories\Modules\Material\Database\Factories;

use App\Models\User;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Material\Models\Material;
use App\Modules\Material\Models\MaterialUsage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaterialUsage>
 */
class MaterialUsageFactory extends Factory
{
    protected $model = MaterialUsage::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'material_id' => Material::factory(),
            'appointment_id' => Appointment::factory(),
            'amount_used' => $this->faker->randomFloat(2, 0.1, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function forMaster(User $master): MaterialUsageFactory|Factory
    {
        return $this->state(function (array $attributes) use ($master) {
            return [
                'user_id' => $master->id,
            ];
        });
    }

    public function forMaterial(Material $material): MaterialUsageFactory|Factory
    {
        return $this->state(function (array $attributes) use ($material) {
            return [
                'material_id' => $material->id,
                'user_id' => $material->muser_id,
            ];
        });
    }

    public function forAppointment(Appointment $appointment): MaterialUsageFactory|Factory
    {
        return $this->state(function (array $attributes) use ($appointment) {
            return [
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id,
            ];
        });
    }

    public function smallAmount(): MaterialUsageFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'amount_used' => $this->faker->randomFloat(2, 0.1, 5),
            ];
        });
    }

    public function largeAmount(): MaterialUsageFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'amount_used' => $this->faker->randomFloat(2, 10, 100),
            ];
        });
    }
}
