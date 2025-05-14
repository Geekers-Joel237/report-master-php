<?php

namespace App\Core\Objective\Domain\Dto;

readonly class FilterObjectiveParams
{
    public function __construct(
        public ?string $projectId,

        public ?string $startDate,

        public ?string $endDate,

        public ?string $year,

        public ?string $ownerId,

        public ?array $participantIds,

        public ?int $limit,

        public ?int $offset,
    ) {}
}
