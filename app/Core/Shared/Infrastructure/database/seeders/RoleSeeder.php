<?php

namespace Database\Seeders;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\ACL\Infrastructure\Models\Role;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleEnum::values() as $role) {
            Role::query()->create([
                'id' => Uuid::uuid4()->toString(),
                'name' => $role,
                'description' => $role,
            ]);
        }
    }
}
