<?php

namespace App\Core\Project\Application\Query\All;

class ProjectDto
{
    public string $projectId = '';
    public string $name = '';
    public string $description = '';
    public string $status = '';
    public string $createdAt = '';
    public ?string $updatedAt = null;
}
