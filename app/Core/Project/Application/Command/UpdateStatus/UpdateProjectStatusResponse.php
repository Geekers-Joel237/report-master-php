<?php

namespace App\Core\Project\Application\Command\UpdateStatus;

class UpdateProjectStatusResponse
{
    public bool $isSaved = false;

    public string $message = '';

    public string $projectId = '';
}
