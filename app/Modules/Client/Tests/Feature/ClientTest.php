<?php

namespace App\Modules\Auth\Tests;

use App\Modules\Auth\Models\User;
use App\Modules\Client\Http\Requests\ClientRequest;
use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Repositories\ClientRepository;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected ClientRepository $clientRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = new ClientRepository();
    }

    #[Test]
    public function testIndex()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(self::BASE_PATH . '/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
            ])
            ->assertJson([
                'data' => [],
            ]);
    }

    #[Test]
    public function testCreateClientWithValidData()
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user);

        $clientData = [
            'user_id' => $user->id,
            'first_name' => $faker->firstName
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(self::BASE_PATH . '/clients', $clientData);

        $response->assertCreated();

        $client = Client::first();

        $response->assertJsonFragment([
            'id' => $client->id,
            'first_name' => $client->first_name,
        ]);

        $this->assertDatabaseHas('clients', $clientData);
    }
}
