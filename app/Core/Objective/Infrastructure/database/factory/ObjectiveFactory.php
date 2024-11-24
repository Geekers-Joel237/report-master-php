<?php

namespace App\Core\Objective\Infrastructure\database\factory;

use App\Core\Objective\Infrastructure\Model\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory
{
    protected $model = Objective::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'project_id' => $this->faker->uuid(),
        ];
    }
}
