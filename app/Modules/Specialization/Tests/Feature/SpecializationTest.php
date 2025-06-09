<?php

namespace Feature;

use App\Models\User;
use App\Modules\Specialization\Models\Specialization;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpecializationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $specFactory = Specialization::factory(2)->create();

        $response = $this->getJson(self::BASE_PATH . '/specializations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'description',
                        'services' => []
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    [
                        'id' => $specFactory[0]['id'],
                        'name' => $specFactory[0]['name'],
                        'description' => $specFactory[0]['description'],
                        'services' => [],
                    ]
                ],
            ]);
    }

    #[Test]
    public function testCreate(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $specData = [
            'name' => $faker->word,
            'description' => $faker->text,
        ];

        $response = $this->postJson(self::BASE_PATH . '/specializations', $specData);

        $response->assertCreated();

        $spec = Specialization::first();

        $response->assertJsonFragment([
            'id' => $spec->id,
            'name' => $spec['name'],
            'description' => $spec['description'],
        ]);

        $this->assertDatabaseHas('specializations', $specData);
    }

    #[Test]
    public function testUpdateSpecialization(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $spec = Specialization::create([
            'name' => $faker->word,
            'description' => $faker->text,
        ]);

        $updateData = [
            'name' => $faker->word,
            'description' => $faker->text,
        ];

        $response = $this->putJson(self::BASE_PATH . '/specializations/' . $spec->id, $updateData);
        $response->assertOk();

        $updatedSpec = Specialization::find($spec->id);

        $response->assertJsonFragment([
            'id' => $updatedSpec->id,
            'name' => $updatedSpec['name'],
            'description' => $updatedSpec['description'],
        ]);

        $this->assertDatabaseHas('specializations', [
            'id' => $spec->id,
            'name' => $updatedSpec['name'],
            'description' => $updatedSpec['description'],
        ]);
    }

    #[Test]
    public function testDeleteSpecialization(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $spec = Specialization::create([
            'name' => $faker->word,
            'description' => $faker->text,
        ]);

        $response = $this->deleteJson(self::BASE_PATH . '/specializations/' . $spec->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Специализация успешно удалена',
                'code' => 200
            ]);

        $this->assertDatabaseMissing('specializations', [
            'id' => $spec->id
        ]);
    }
}
