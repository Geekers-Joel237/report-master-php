<?php

namespace App\Core\Domain\Entities;

use DateTimeImmutable;

class Project
{
    private ?DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $updatedAt;

    final private function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public ?string $description,
    ) {
        $this->updatedAt = null;
        $this->createdAt = null;
    }

    public static function create(string $id, string $name, ?string $description = null, ?string $existingId = null): static
    {
        $projectId = $existingId ?? $id;
        $static = new static($projectId, $name, $description);
        $existingId ? $static->updatedAt = new DateTimeImmutable() : $static->createdAt = new DateTimeImmutable();

        return $static;
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
