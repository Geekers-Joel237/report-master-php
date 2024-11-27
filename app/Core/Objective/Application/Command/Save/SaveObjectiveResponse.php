<?php

namespace App\Core\Objective\Application\Command\Save;

class SaveObjectiveResponse
{
    public bool $isSaved = false;

    public string $message = '';

    public string $objectiveId = '';
}
