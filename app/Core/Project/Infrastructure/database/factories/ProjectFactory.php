<?php

namespace App\Core\Project\Infrastructure\database\factories;

use App\Core\Project\Domain\Enums\ProjectStatusEnum;
use App\Core\Project\Infrastructure\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'status' => ProjectStatusEnum::Started->value,
        ];
    }
}
