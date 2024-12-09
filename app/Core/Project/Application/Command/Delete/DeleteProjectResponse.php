<?php

namespace App\Core\Project\Application\Command\Delete;

class DeleteProjectResponse
{
    public bool $isDeleted = false;

    public string $message = '';

    public int $code = 500;
}
