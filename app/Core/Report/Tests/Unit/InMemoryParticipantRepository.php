<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\User\Domain\WriteUserRepository;

class InMemoryParticipantRepository implements WriteUserRepository
{
    public array $participantIds = [];

    public function __construct() {}

    public function allExists(array $participantIds): array
    {
        return array_intersect($participantIds, $this->participantIds);
    }
}
