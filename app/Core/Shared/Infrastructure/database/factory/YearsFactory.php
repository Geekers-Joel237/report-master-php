<?php

namespace App\Core\Shared\Infrastructure\database\factory;

use App\Core\Shared\Infrastructure\Models\Years;
use Illuminate\Database\Eloquent\Factories\Factory;

class YearsFactory extends Factory
{
    protected $model = Years::class;

    /**
     * @return array<string, string|true>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'year' => $this->faker->year(),
            'is_active' => true,
        ];
    }
}
