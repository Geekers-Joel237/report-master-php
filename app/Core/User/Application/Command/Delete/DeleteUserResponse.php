<?php

namespace App\Core\User\Application\Command\Delete;

class DeleteUserResponse
{
    public bool $isDeleted = false;

    public int $code = 500;

    public string $message = 'Deleted successful';
}
