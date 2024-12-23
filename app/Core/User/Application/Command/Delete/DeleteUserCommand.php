<?php

namespace App\Core\User\Application\Command\Delete;

readonly class DeleteUserCommand
{
    public function __construct(
        public string $userId
    ) {}
}
