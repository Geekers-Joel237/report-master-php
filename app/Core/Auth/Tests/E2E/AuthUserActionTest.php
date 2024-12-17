<?php

namespace App\Core\Auth\Tests\E2E;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\ACL\Infrastructure\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AuthUserActionTest extends TestCase
{
    use RefreshDatabase;

    private Role $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::query()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => RoleEnum::DEVELOPER->value,
            'description' => RoleEnum::DEVELOPER->value,
        ]);
    }

    public function test_can_login_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => RoleEnum::DEVELOPER->value,
        ];
        $this->postJson('/api/v1/users', $data);

        $loginData = [
            'email' => 'john@doe.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/login', $loginData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'authUser' => [
                    'userId',
                    'name',
                    'email',
                    'roleId',
                    'roleName',
                    'token',
                ],
            ],
            'metadata' => [],
        ]);

    }
}
