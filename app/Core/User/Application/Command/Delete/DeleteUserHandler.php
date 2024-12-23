<?php

namespace App\Core\User\Application\Command\Delete;

use App\Core\User\Domain\Exceptions\NotFoundUserException;
use App\Core\User\Domain\Repository\WriteUserRepository;

final readonly class DeleteUserHandler
{
    public function __construct(
        private WriteUserRepository $repository
    ) {}

    /**
     * @throws NotFoundUserException
     */
    public function handle(DeleteUserCommand $command): DeleteUserResponse
    {

        $response = new DeleteUserResponse;
        $this->checkUserIfExistOrThrowNotFoundException($command->userId);
        $this->repository->delete($command->userId);
        $response->isDeleted = true;
        $response->code = 200;

        return $response;

    }

    /**
     * @throws NotFoundUserException
     */
    private function checkUserIfExistOrThrowNotFoundException(string $userId): void
    {

        if (! $this->repository->exists($userId)) {
            throw new NotFoundUserException;
        }

    }
}
