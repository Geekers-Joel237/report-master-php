<?php

namespace Database\Seeders;

use App\Core\Shared\Domain\IdGenerator;
use App\Core\Shared\Infrastructure\Models\Years;
use Illuminate\Database\Seeder;

class YearsSeeder extends Seeder
{
    public function __construct(
        private readonly IdGenerator $idGenerator,
    ) {}

    public function run(): void
    {
        Years::insert([
            [
                'id' => $this->idGenerator->generate(),
                'year' => '2025',
                'is_active' => false,
            ],
            [
                'id' => $this->idGenerator->generate(),
                'year' => '2024',
                'is_active' => true,
            ],
            [
                'id' => $this->idGenerator->generate(),
                'year' => '2023',
                'is_active' => false,
            ],
        ]);
    }
}
