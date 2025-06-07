<?php

namespace Feature;

use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\AuthRepository;
use App\Modules\Master\Models\Master;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected AuthRepository $authRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authRepository = new AuthRepository();
    }

    #[Test] public function it_can_register_a_user(): void
    {
        // Подготовка
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'second_name' => 'Smith',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
        ];

        // Действие
        $user = $this->authRepository->registerUser($userData);

        // Проверка
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function it_returns_user_information_when_authenticated_user_calls_me_method(): void
    {
        // Подготовка
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $master = Master::factory()->create(['user_id' => $user->id]);
        $specialization = Specialization::factory()->create();
        $master->specializations()->attach($specialization);

        // Обновляем загруженные отношения
        $user->refresh()->load('master.specializations');

        $this->actingAs($user);

        // Действие
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(self::BASE_PATH . '/auth/me');

        // Проверка
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                ],
            ]);
    }

    #[Test]
    public function it_logs_out_authenticated_user(): void
    {
        // Подготовка
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $this->actingAs($user);

        // Действие
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(self::BASE_PATH . '/auth/logout');

        // Проверка
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logged out',
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', (string) $token),
        ]);
    }
}
