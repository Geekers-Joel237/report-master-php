<?php

namespace App\Core\User\Tests\E2E;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\ACL\Infrastructure\Models\Role;
use App\Core\Shared\Infrastructure\Lib\LaravelHasher;
use App\Core\User\Domain\Vo\Hasher;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class SaveUserActionTest extends TestCase
{
    use RefreshDatabase;

    private Hasher $hasher;

    private Role $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->hasher = new LaravelHasher;
        $this->role = Role::query()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => RoleEnum::DEVELOPER->value,
            'description' => RoleEnum::DEVELOPER->value,
        ]);
    }

    public function test_can_create_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => RoleEnum::DEVELOPER->value,
        ];
        $response = $this->postJson('/api/v1/users', $data);
        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
            'id' => $response->json()['userId'],
        ]);
        $this->assertDatabaseHas('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $response->json()['userId'],
        ]);
        $this->assertTrue($this->hasher->check(
            $data['password'],
            User::query()->find($response->json()['userId'])->password)
        );
    }

    public function test_can_update_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => RoleEnum::DEVELOPER->value,
        ];
        $response1 = $this->postJson('/api/v1/users', $data);
        $this->assertTrue($response1->json()['isSaved']);

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'john@doe.com',
            'userId' => $userId = $response1->json()['userId'],
        ];
        $response = $this->putJson('/api/v1/users/'.$userId, $updatedData);

        $response->assertOk();
        $this->assertEquals($response1->json()['userId'], $updatedData['userId']);

        $dbUser = User::query()->find($updatedData['userId']);
        $this->assertEquals($dbUser->name, $updatedData['name']);
        $this->assertEquals($dbUser->email, $updatedData['email']);
    }
}
