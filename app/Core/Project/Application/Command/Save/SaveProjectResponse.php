<?php

namespace App\Core\Project\Application\Command\Save;

class SaveProjectResponse
{
    public bool $isSaved = false;

    public string $projectId = '';

    public string $message = '';
}
