<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Запускает DatabaseSeeder
    }

    public function testSuccessRegistration()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            "first_name" => "Мария",
            "last_name" => "Иванова",
            "second_name" => "Петровна",
            "email" => "maria@example.com",
            "phone" => "+79161234566",
            "password" => "password123",
            "password_confirmation" => "password123"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'maria@example.com',
            'phone' => '+79161234566'
        ]);

        $this->assertTrue(User::where('email', 'maria@example.com')
            ->first()
            ->hasRole('master'));
    }

    public function testLoginByEmail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/v1/auth/login', [
            'login' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
    }

    public function testLoginByPhone()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/v1/auth/login', [
            'login' => $user->phone,
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
    }

    public function testSuccessfulLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/auth/logout');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logged out'
        ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function testMe()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage-clients');
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'master' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
            ],
            'permissions'
        ]);
        $response->assertJson([
            'master' => $user->toArray(),
            'permissions' => ['manage-clients']
        ]);
    }
}
