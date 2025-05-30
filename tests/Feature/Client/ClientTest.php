<?php

namespace Tests\Feature\Client;

use App\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Запускает DatabaseSeeder
    }

//    public function test_index_returns_paginated_collection_of_clients_for_authenticated_user()
//    {
//        $user = User::factory()->create();
//        $this->actingAs($user);
//
//        Client::factory()->count(20)->create(['user_id' => $user->id]);
//
//        $response = $this->getJson('/api/clients');
//
//        $response->assertStatus(200)
//            ->assertJsonStructure([
//                'data' => [
//                    '*' => [
//                        'id',
//                        'name',
//                        'phone',
//                        'email',
//                        'last_appointment' => [
//                            'id',
//                            'start_time',
//                            'status'
//                        ]
//                    ]
//                ],
//                'links',
//                'meta'
//            ])
//            ->assertJsonCount(15, 'data');
//
//        $this->assertEquals(15, $response->json('meta.per_page'));
//        $this->assertEquals(2, $response->json('meta.last_page'));
//    }

    public function test_store_creates_new_client_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $clientData = [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'email' => 'john@example.com',
        ];

        $response = $this->postJson('/api/v1/clients', $clientData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'phone',
                    'email',
                ]
            ]);

        $this->assertDatabaseHas('clients', [
            'user_id' => $user->id,
            'name' => 'John Doe',
            'phone' => '1234567890',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals('Клиент успешно создан', $response->json('message'));
    }

//    public function test_show_returns_client_for_authorized_user_and_denies_for_unauthorized()
//    {
//        $user1 = User::factory()->create();
//        $user2 = User::factory()->create();
//
//        $client1 = Client::factory()->create(['user_id' => $user1->id]);
//        $client2 = Client::factory()->create(['user_id' => $user2->id]);
//
//        $this->actingAs($user1);
//
//        $response = $this->getJson("/api/v1/clients/{$client1->id}");
//        $response->assertStatus(200)
//            ->assertJsonStructure([
//                'data' => [
//                    'id',
//                    'name',
//                    'phone',
//                    'email',
//                    'appointments',
//                    'notes'
//                ]
//            ]);
//
//        $response = $this->getJson("/api/v1/clients/{$client2->id}");
//        $response->assertStatus(403);
//    }

    public function test_update_persists_client_data_after_subsequent_fetch()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'name' => 'Jane Doe',
            'phone' => '9876543210',
            'email' => 'jane@example.com',
        ];

        $response = $this->putJson("/api/v1/clients/{$client->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'phone',
                    'email',
                ]
            ]);

        $this->assertEquals('Данные клиента обновлены', $response->json('message'));

        // Fetch the client data again to verify persistence
        $fetchResponse = $this->getJson("/api/v1/clients/{$client->id}");

        $fetchResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Jane Doe',
                    'phone' => '9876543210',
                    'email' => 'jane@example.com',
                ]
            ]);
    }
}
