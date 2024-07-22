<?php

namespace App\Core\Application\Command\Project\Save;

readonly class SaveProjectCommand
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $id = null,
    ) {}
}
