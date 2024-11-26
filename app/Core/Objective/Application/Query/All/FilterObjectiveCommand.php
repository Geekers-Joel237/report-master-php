<?php

namespace App\Core\Objective\Application\Query\All;

class FilterObjectiveCommand
{
    public ?string $projectId = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $year = null;

    public ?string $ownerId = null;

    public ?array $participantIds = [];

    public ?int $limit = null;

    public ?int $offset = null;

    public function __construct() {}
}
