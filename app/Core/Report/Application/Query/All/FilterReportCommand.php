<?php

namespace App\Core\Report\Application\Query\All;

class FilterReportCommand
{
    public ?string $projectId = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $year = null;

    public ?string $ownerId = null;

    public ?array $participantIds = [];

    public ?int $limit = null;

    public ?int $offset = null;
}
