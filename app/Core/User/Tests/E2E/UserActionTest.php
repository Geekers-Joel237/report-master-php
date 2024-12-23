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

class UserActionTest extends TestCase
{
    use RefreshDatabase;

    private Hasher $hasher;

    private Role $role;

    private User $user;

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
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
            'id' => $response->json()['data']['userId'],
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $this->role->id,
            'model_id' => $response->json()['data']['userId'],
            'model_type' => User::class,
        ]);
        $this->assertTrue($this->hasher->check(
            $data['password'],
            User::query()->find($response->json()['data']['userId'])->password)
        );
        $this->assertNotNull($response->json()['data']['token']);
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
        $this->assertTrue($response1->json()['data']['isSaved']);
        $this->user = User::query()->find($response1->json()['data']['userId']);

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'john@doe.com',
            'userId' => $userId = $response1->json()['data']['userId'],
        ];
        $response = $this->actingAs($this->user)->putJson('/api/v1/users/'.$userId, $updatedData);

        $response->assertStatus(201);
        $this->assertEquals($response1->json()['data']['userId'], $updatedData['userId']);

        $dbUser = User::query()->find($updatedData['userId']);
        $this->assertEquals($dbUser->name, $updatedData['name']);
        $this->assertEquals($dbUser->email, $updatedData['email']);
    }

    public function test_can_delete_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => RoleEnum::DEVELOPER->value,
        ];
        $response1 = $this->postJson('/api/v1/users', $data);
        $this->assertTrue($response1->json()['data']['isSaved']);

        $userId = $response1->json()['data']['userId'];
        $this->user = User::factory()->create();
        $response = $this->actingAs($this->user)->deleteJson('/api/v1/user/'.$userId);
        $response->assertStatus(200);
        $this->assertTrue($response->json()['data']['isDeleted']);

        $dbUser = User::query()->where(['id' => $userId])
            ->whereNotNull(['deleted_at'])
            ->where(['is_deleted' => true])
            ->first();
        $this->assertSoftDeleted('users', $dbUser->toArray());

    }

    public function test_can_get_user_profile(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => RoleEnum::DEVELOPER->value,
        ];
        $res = $this->postJson('/api/v1/users', $data);
        $this->user = User::query()->find($res->json()['data']['userId']);

        $response = $this->actingAs($this->user)->getJson('/api/v1/users/'.$res->json()['data']['userId']);
        $response->assertStatus(200);
        $this->assertEquals([
            'userId' => $res->json()['data']['userId'],
            'name' => $data['name'],
            'email' => $data['email'],
            'roleName' => $data['role'],
            'roleId' => $this->role->id,
        ], $response->json()['data']);

    }
}
