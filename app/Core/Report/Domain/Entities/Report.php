<?php

namespace App\Core\Report\Domain\Entities;

use App\Core\Report\Domain\Snapshots\ReportSnapshot;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use DateTimeImmutable;
use Exception;

class Report
{
    private ?DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $updatedAt;

    final private function __construct(
        private readonly string $reportId,
        private readonly string $projectId,
        private array $tasks,
        private array $participants,
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
        array $participants,
        string $reportId
    ): static {
        if (empty($tasks)) {
            throw new InvalidCommandException('Tasks  should not be empty', 400);
        }
        $report = new static(
            reportId: $reportId,
            projectId: $projectId,
            tasks: $tasks,
            participants: $participants,
        );
        $report->createdAt = new DateTimeImmutable;

        return $report;
    }

    /**
     * @throws Exception
     */
    public static function createFromAdapter(
        string $reportId,
        string $projectId,
        array $tasks,
        array $participants,
        string $createdAt
    ): static {
        $report = new static(
            reportId: $reportId,
            projectId: $projectId,
            tasks: $tasks,
            participants: $participants,
        );
        $report->createdAt = $createdAt ? new DateTimeImmutable($createdAt) : null;

        return $report;
    }

    public function snapshot(): ReportSnapshot
    {
        return new ReportSnapshot(
            id: $this->reportId,
            projectId: $this->projectId,
            tasks: $this->tasks,
            participants: $this->participants,
            createdAt: $this->createdAt?->format('Y-m-d H:i:s'),
            updatedAt: $this->updatedAt?->format('Y-m-d H:i:s')
        );
    }

    /**
     * @throws InvalidCommandException
     */
    public function update(array $tasks, array $participants): Report|static
    {
        if (empty($tasks)) {
            throw new InvalidCommandException('Tasks  should not be empty', 400);
        }

        $report = clone $this;
        $report->tasks = $tasks;
        $report->participants = $participants;
        $report->updatedAt = new DateTimeImmutable;

        return $report;

    }
}
