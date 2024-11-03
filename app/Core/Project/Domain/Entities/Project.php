<?php

namespace App\Core\Project\Domain\Entities;

use App\Core\Project\Domain\Enums\ProjectStatusEnum;
use App\Core\Project\Domain\Snapshot\ProjectSnapshot;
use App\Core\Project\Domain\Vo\NameVo;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

class Project
{
    private ?DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $updatedAt;

    final private function __construct(
        readonly private string $id,
        private NameVo $name,
        private ?string $description,
        private ProjectStatusEnum $status
    ) {
        $this->updatedAt = null;
        $this->createdAt = null;
    }

    public static function create(
        string $id,
        NameVo $name,
        ?string $description = null,
        ProjectStatusEnum $status = ProjectStatusEnum::Started
    ): static {
        $projectId = $id;
        $static = new static($projectId, $name, $description, $status);
        $static->createdAt = new DateTimeImmutable;

        return $static;
    }

    /**
     * @throws Exception
     */
    public static function createFromAdapter(
        string $id,
        string $name,
        string $status,
        ?string $description,
        ?string $createdAt,
        ?string $updatedAt
    ): static {
        $project = new static($id, new NameVo($name), $description, ProjectStatusEnum::in($status));
        $project->createdAt = $createdAt ? new DateTimeImmutable($createdAt) : null;
        $project->updatedAt = $updatedAt ? new DateTimeImmutable($updatedAt) : null;

        return $project;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function updateStatus(string $status): void
    {
        $this->status = ProjectStatusEnum::in($status);
        $this->updatedAt = new DateTimeImmutable;
    }

    public function update(NameVo $name, ?string $description): self
    {
        $clone = clone $this;
        $clone->name = $name;
        $clone->description = $description;
        $clone->updatedAt = new DateTimeImmutable;

        return $clone;
    }

    public function snapshot(): ProjectSnapshot
    {
        return new ProjectSnapshot(
            id: $this->id,
            name: $this->name->value(),
            description: $this->description,
            status: $this->status->value,
            createdAt: $this->createdAt?->format('Y-m-d H:i:s'),
            updatedAt: $this->updatedAt?->format('Y-m-d H:i:s'),
        );
    }
}
