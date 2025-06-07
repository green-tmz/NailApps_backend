<?php

namespace Feature;

use App\Models\User;
use App\Modules\Auth\Repositories\AuthRepository;
use App\Modules\Master\Models\Master;
use App\Modules\Specialization\Models\Specialization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthRepositoryTest extends TestCase
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
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'second_name' => 'Smith',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
        ];

        $user = $this->authRepository->registerUser($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test] public function it_can_create_a_master_with_specialization(): void
    {
        $user = User::factory()->create();
        $specialization = Specialization::factory()->create();

        Role::create(['name' => 'master']);

        $master = $this->authRepository->createMaster($user, $specialization->id);

        $this->assertInstanceOf(Master::class, $master);
        $this->assertDatabaseHas('masters', ['user_id' => $user->id]);
        $this->assertTrue($user->hasRole('master'));
        $this->assertEquals(1, $master->specializations()->count());
        $this->assertEquals($specialization->id, $master->specializations()->first()->id);
    }

    //    #[Test] public function it_can_register_a_master_with_transaction(): void
    //    {
    //        $specialization = Specialization::factory()->create();
    //        $requestData = [
    //            'first_name' => 'Jane',
    //            'last_name' => 'Doe',
    //            'second_name' => 'Ann',
    //            'email' => 'jane.doe@example.com',
    //            'phone' => '+9876543210',
    //            'password' => 'secret123',
    //            'specializationId' => $specialization->id,
    //        ];
    //
    //        $response = $this->authRepository->registerUser((array)new RegisterRequest($requestData));
    //
    //        $this->assertInstanceOf(RegisterResource::class, $response);
    //
    //        $user = User::where('email', 'jane.doe@example.com')->first();
    //        $this->assertNotNull($user);
    //        $this->assertTrue($user->hasRole('master'));
    //
    //        $master = Master::where('user_id', $user->id)->first();
    //        $this->assertNotNull($master);
    //        $this->assertEquals($specialization->id, $master->specializations()->first()->id);
    //    }

    //    #[Test] public function it_rolls_back_transaction_on_failure_during_registration(): void
    //    {
    //        // Подготовка
    //        $specialization = Specialization::factory()->create();
    //        $requestData = [
    //            'first_name' => 'Fail',
    //            'last_name' => 'User',
    //            'second_name' => 'Test',
    //            'email' => 'fail.user@example.com',
    //            'phone' => '+1111111111',
    //            'password' => 'password',
    //            'specializationId' => $specialization->id,
    //        ];
    //
    //        // Создаем мок DB
    //        DB::shouldReceive('beginTransaction')->once();
    //        DB::shouldReceive('rollBack')->once();
    //        DB::shouldReceive('commit')->never();
    //
    //        // Создаем мок для зависимости, которая вызывает ошибку
    //        $failingService = $this->createMock(SomeService::class);
    //        $failingService->method('createMaster')
    //            ->willThrowException(new \Exception('Test exception'));
    //
    //        // Создаем репозиторий с моком
    //        $repository = new AuthRepository($failingService);
    //
    //        $this->expectException(\Exception::class);
    //
    //        // Действие
    //        $repository->register(new RegisterRequest($requestData));
    //
    //        // Проверки
    //        $this->assertDatabaseMissing('users', ['email' => 'fail.user@example.com']);
    //    }

    #[Test] public function it_handles_null_email_and_phone_correctly(): void
    {
        // Подготовка
        $userData = [
            'first_name' => 'No',
            'last_name' => 'Contact',
            'second_name' => 'User',
            'email' => null,
            'phone' => null,
            'password' => 'password123',
        ];

        // Действие
        $user = $this->authRepository->registerUser($userData);

        // Проверка
        $this->assertNull($user->email);
        $this->assertNull($user->phone);
    }
}
