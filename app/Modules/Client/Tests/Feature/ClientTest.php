<?php

namespace Feature;

use App\Modules\Auth\Models\User;
use App\Modules\Client\Models\Client;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    use HasApiTokens;

    #[Test]
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(self::BASE_PATH . '/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
            ])
            ->assertJson([
                'data' => [],
            ]);
    }

    #[Test]
    public function testCreate(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $clientData = [
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'last_name' => $faker->lastName,
            'second_name' => $faker->name,
            'birth_date' => $faker->date,
            'notes' => $faker->text,
        ];

        $response = $this->postJson(self::BASE_PATH . '/clients', $clientData);

        $response->assertCreated();

        $client = Client::first();

        $response->assertJsonFragment([
            'id' => $client->id,
            'firstName' => $client->first_name,
            'phone' => $client->phone,
            'email' => $client->email,
            'lastName' => $client->last_name,
            'secondName' => $client->second_name,
            'birthDate' => Carbon::parse($client->birth_date)->format("Y-m-d"),
            'notes' => $client->notes,
        ]);

        $this->assertDatabaseHas('clients', $clientData);
    }

    #[Test]
    public function testUpdateClient(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user);

        $client = Client::create([
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'last_name' => $faker->lastName,
            'second_name' => $faker->name,
            'birth_date' => $faker->date,
            'notes' => $faker->text,
        ]);

        $updateData = [
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'last_name' => $faker->lastName,
            'second_name' => $faker->name,
            'birth_date' => $faker->date,
            'notes' => $faker->text,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(self::BASE_PATH . '/clients/' . $client->id, $updateData);

        $response->assertOk();

        $updatedClient = Client::find($client->id);

        $response->assertJsonFragment([
            'id' => $updatedClient->id,
            'firstName' => $updatedClient->first_name,
            'lastName' => $updatedClient->last_name,
            'phone' => $updatedClient->phone,
            'email' => $updatedClient->email,
        ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'first_name' => $updateData['first_name'],
            'last_name' => $updateData['last_name'],
            'phone' => $updateData['phone'],
            'email' => $updateData['email'],
        ]);
    }


    #[Test]
    public function testDeleteClient(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user);

        $client = Client::create([
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'last_name' => $faker->lastName,
            'second_name' => $faker->name,
            'birth_date' => $faker->date,
            'notes' => $faker->text,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(self::BASE_PATH . '/clients/' . $client->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Клиент успешно удален',
            ]);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id
        ]);
    }
}
