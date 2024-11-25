<?php

namespace App\Core\Report\Infrastructure\database\factory;

use App\Core\Report\Infrastructure\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'project_id' => $this->faker->uuid(),
            'tasks' => $this->faker->text(),
            'owner_id' => $this->faker->uuid(),
        ];
    }
}
