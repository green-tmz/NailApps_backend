<?php

namespace Feature;

use Faker\Factory;
use App\Models\User;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Repositories\ClientRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ClientRepository $clientRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = new ClientRepository();
    }

    #[Test]
    public function testGetAllWithUserReturnsEmptyCollectionWhenNoClients(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $clients = $this->clientRepository->getAllWithUser();

        $this->assertInstanceOf(Collection::class, $clients);
        $this->assertTrue($clients->isEmpty());
    }

    #[Test]
    public function testCreateClientWithValidData(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $clientData = [
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'second_name' => $faker->name,
            'birth_date' => $faker->date,
            'notes' => $faker->text,
            'email' => $faker->unique()->email,
            'phone' => $faker->unique()->phoneNumber,
        ];

        $client = $this->clientRepository->create($clientData);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', $clientData);
        $this->assertEquals($clientData['user_id'], $client->user_id);
        $this->assertEquals($clientData['first_name'], $client->first_name);
        $this->assertEquals($clientData['last_name'], $client->last_name);
        $this->assertEquals($clientData['second_name'], $client->second_name);
        $this->assertEquals($clientData['birth_date'], Carbon::parse($client->birth_date)->format("Y-m-d"));
        $this->assertEquals($clientData['notes'], $client->notes);
        $this->assertEquals($clientData['email'], $client->email);
        $this->assertEquals($clientData['phone'], $client->phone);
    }

    #[Test]
    public function testGetByIdWithUserReturnsClientWithAssociatedUser(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $client = Client::create([
            'user_id' => $user->id,
            'first_name' => $faker->firstName
        ]);
        $this->actingAs($user);

        $result = $this->clientRepository->getByIdWithUser($client->id);

        $this->assertInstanceOf(Client::class, $result);
        $this->assertEquals($client->id, $result->id);
        $this->assertTrue($result->relationLoaded('user'));
        $this->assertEquals($user->id, $result->user->id);
    }

    #[Test]
    public function testUpdateClientWithValidData(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create([
            'user_id' => $user->id,
            'first_name' => $faker->firstName
        ]);

        $updatedData = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
        ];

        $updatedClient = $this->clientRepository->update($client, $updatedData);

        $this->assertInstanceOf(Client::class, $updatedClient);
        $this->assertEquals($client->id, $updatedClient->id);
        $this->assertEquals($updatedData['first_name'], $updatedClient->first_name);
        $this->assertEquals($updatedData['last_name'], $updatedClient->last_name);
        $this->assertEquals($updatedData['email'], $updatedClient->email);
        $this->assertDatabaseHas('clients', $updatedData);
    }

    #[Test]
    public function testDeleteClientSuccessfully(): void
    {
        $faker = Factory::create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create([
            'user_id' => $user->id,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->email,
        ]);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $this->clientRepository->delete($client);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
