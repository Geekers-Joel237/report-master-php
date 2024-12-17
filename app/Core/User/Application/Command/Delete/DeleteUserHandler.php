<?php

namespace App\Core\User\Application\Command\Delete;

use App\Core\User\Domain\Entities\User;
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

    public function handle(DeleteUserCommand $command) : DeleteUserResponse{

        $response = new DeleteUserResponse;
        $user = $this->getUserIfExistOrThrowNotFoundException($command->userId);
        $user = $user->delete($command->userId);
        $this->repository->delete($user->snapshot());
        $response->isdeleted = 1;
        $response->code = 201;

        return $response;


    }

    /**
     * @param string|null $userId
     * @return User
     * @throws NotFoundUserException
     */
    private function getUserIfExistOrThrowNotFoundException(string $userId): User
    {
        $eUser = $this->repository->exists($userId);
        if (is_null($eUser)) {
            throw new NotFoundUserException;
        }

        return $eUser;
    }
}
