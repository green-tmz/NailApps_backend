<?php

namespace Feature;

use App\Models\User;
use App\Modules\Master\Models\Master;
use App\Modules\Service\Models\Service;
use App\Modules\Specialization\Models\Specialization;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $master = Master::factory()->create(['user_id' => $user['id']]);

        $this->actingAs($user);

        $service = Service::factory()->create();
        $service->master()->attach($master->id);

        $response = $this->getJson(self::BASE_PATH . '/services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'duration',
                        'price',
                        'specialization',
                        'master'
                    ]
                ]
            ]);
    }

    #[Test]
    public function testCreateService(): void
    {
        $faker = Factory::create();
        $user = User::factory()->create();
        $master = Master::factory()->create(['user_id' => $user['id']]);
        $specialization = Specialization::factory()->create();

        $this->actingAs($user);

        $serviceData = [
            'specialization_id' => $specialization['id'],
            'name' => $faker->word,
            'description' => $faker->text,
            'duration' => $faker->numberBetween(15, 120),
            'price' => $faker->randomFloat(2, 10, 500),
        ];

        $response = $this->postJson(self::BASE_PATH . '/services', $serviceData);

        $service = Service::first();

        $response->assertJson([
            'data' => [
                'id' => $service->id,
                'name' => $service['name'],
                'description' => $service['description'],
                'duration' => $service['duration'],
                'price' => (float)$service['price'],
                'specialization' => [
                    'id' => $specialization['id'],
                    'name' => $specialization['name'],
                    'description' => $specialization['description'],
                ],
                'master' => [
                    'id' => $user['id'],
                    'first_name' => $master->user->first_name,
                    'last_name' => $master->user->last_name,
                ],
            ]
        ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => $serviceData['name'],
            'description' => $serviceData['description'],
            'duration' => $serviceData['duration'],
            'price' => $serviceData['price'],
            'specialization_id' => $serviceData['specialization_id'],
        ]);

        $this->assertDatabaseHas('master_service', [
            'service_id' => $service->id,
            'master_id' => $master->id,
        ]);
    }

    #[Test]
    public function testUpdateClient(): void
    {
        $faker = Factory::create();
        $user = User::factory()->create();
        $master = Master::factory()->create(['user_id' => $user['id']]);
        [$specialization, $updateSpec] = Specialization::factory(2)->create();

        $this->actingAs($user);

        $service = Service::create([
            'specialization_id' => $specialization['id'],
            'name' => $faker->word,
            'description' => $faker->text,
            'duration' => $faker->numberBetween(15, 120),
            'price' => $faker->randomFloat(2, 10, 500),
        ]);
        $service->master()->attach($master->id);

        $updateData = [
            'specialization_id' => $updateSpec['id'],
            'name' => $faker->word,
            'description' => $faker->text,
            'duration' => $faker->numberBetween(15, 120),
            'price' => $faker->randomFloat(2, 10, 500),
        ];

        $response = $this->putJson(self::BASE_PATH . '/services/' . $service->id, $updateData);

        $response->assertOk();

        $response->assertJson([
            'data' => [
                'id' => $service->id,
                'name' => $updateData['name'],
                'description' => $updateData['description'],
                'duration' => $updateData['duration'],
                'price' => $updateData['price'],
                'specialization' => [
                    'id' => $updateSpec['id'],
                    'name' => $updateSpec['name'],
                    'description' => $updateSpec['description'],
                ],
                'master' => [
                    'id' => $user['id'],
                    'first_name' => $master->user->first_name,
                    'last_name' => $master->user->last_name,
                ],
            ]
        ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => $updateData['name'],
            'description' => $updateData['description'],
            'duration' => $updateData['duration'],
            'price' => $updateData['price'],
        ]);

        $this->assertDatabaseHas('master_service', [
            'service_id' => $service->id,
            'master_id' => $master['id'],
        ]);
    }

    #[Test]
    public function testDeleteClient(): void
    {
        $faker = Factory::create();
        $user = User::factory()->create();
        $master = Master::factory()->create(['user_id' => $user['id']]);
        $specialization = Specialization::factory()->create();

        $this->actingAs($user);

        $service = Service::create([
            'specialization_id' => $specialization['id'],
            'name' => $faker->word,
            'description' => $faker->text,
            'duration' => $faker->numberBetween(15, 120),
            'price' => $faker->randomFloat(2, 10, 500),
        ]);
        $service->master()->attach($master['id']);

        $response = $this->deleteJson(self::BASE_PATH . '/services/' . $service->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Услуга успешно удалена',
                'code' => 200,
            ]);

        $this->assertDatabaseMissing('services', [
            'id' => $service->id
        ]);
    }
}
