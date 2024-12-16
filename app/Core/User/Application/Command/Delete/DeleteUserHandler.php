<?php

namespace App\Core\User\Application\Command\Delete;

use App\Core\User\Domain\Exceptions\AlreadyEmailExistException;
use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Exceptions\NotFoundUserException;
use App\Core\User\Domain\Repository\WriteUserRepository;

final readonly class DeleteUserHandler
{
    public function __construct(
        private WriteUserRepository $repository
    ){}

    /**
     * @throws AlreadyEmailExistException
     * @throws NotFoundUserException
     * @throws NotEmptyException
     */
}
