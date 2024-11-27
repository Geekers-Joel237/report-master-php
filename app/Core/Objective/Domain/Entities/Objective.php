<?php

namespace App\Core\Objective\Domain\Entities;

use App\Core\Objective\Domain\Snapshot\ObjectiveSnapshot;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use DateTimeImmutable;
use Exception;

class Objective
{
    private ?DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $updatedAt;

    final private function __construct(
        private readonly string $id,
        private readonly string $projectId,
        private readonly string $ownerId,
        private array $tasks,
        private array $participantIds,
    ) {
        $this->createdAt = null;
        $this->updatedAt = null;
    }

    /**
     * @throws InvalidCommandException
     */
    public static function create(
        string $projectId,
        array $tasks,
        array $participantIds,
        string $objectiveId,
        string $ownerId
    ): static {
        if (empty($tasks)) {
            throw new InvalidCommandException('Tasks  should not be empty', 400);
        }
        $objective = new static(
            id: $objectiveId,
            projectId: $projectId,
            ownerId: $ownerId,
            tasks: $tasks,
            participantIds: $participantIds
        );
        $objective->createdAt = new DateTimeImmutable;

        return $objective;
    }

    /**
     * @throws Exception
     */
    public static function createFromDb(
        string $id,
        string $projectId,
        string $ownerId,
        array $tasks,
        array $participantIds,
        string $createdAt,
        ?string $updatedAt
    ): static {
        $objective = new static(
            id: $id,
            projectId: $projectId,
            ownerId: $ownerId,
            tasks: $tasks,
            participantIds: $participantIds,
        );
        $objective->createdAt = $createdAt ? new DateTimeImmutable($createdAt) : null;
        $objective->updatedAt = $updatedAt ? new DateTimeImmutable($updatedAt) : null;

        return $objective;
    }

    /**
     * @throws InvalidCommandException
     */
    public function update(array $tasks, array $participantIds): Objective|static
    {
        if (empty($tasks)) {
            throw new InvalidCommandException('Tasks  should not be empty', 400);
        }

        $objective = clone $this;
        $objective->tasks = $tasks;
        $objective->participantIds = $participantIds;
        $objective->updatedAt = new DateTimeImmutable;

        return $objective;
    }

    public function snapshot(): ObjectiveSnapshot
    {
        return new ObjectiveSnapshot(
            id: $this->id,
            projectId: $this->projectId,
            ownerId: $this->ownerId,
            tasks: $this->tasks,
            participantIds: $this->participantIds,
            createdAt: $this->createdAt?->format('Y-m-d H:i:s'),
            updatedAt: $this->updatedAt?->format('Y-m-d H:i:s')
        );
    }
}
