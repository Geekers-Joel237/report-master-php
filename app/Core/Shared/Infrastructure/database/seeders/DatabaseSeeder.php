<?php

namespace Database\Seeders;

use App\Core\Objective\Infrastructure\Model\Objective;
use App\Core\Project\Infrastructure\Models\Project;
use App\Core\Report\Infrastructure\Models\Report;
use App\Core\Shared\Infrastructure\Models\Years;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $eUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $eProjects = Project::factory(3)->create([
            'year_id' => Years::query()->where('is_active', true)->first()->id,
        ]);
        Report::factory(20)->create([
            'owner_id' => $eUser->id,
            'project_id' => $eProjects->random()->id,
        ]);
        Objective::factory(20)->create([
            'owner_id' => $eUser->id,
            'project_id' => $eProjects->random()->id,
        ]);
    }
}
