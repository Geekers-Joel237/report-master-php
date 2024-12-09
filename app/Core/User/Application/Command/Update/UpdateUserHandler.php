<?php

namespace App\Core\User\Application\Command\Update;

use App\Core\User\Application\Command\Save\SaveUserResponse;
use App\Core\User\Application\Command\Save\UpdateUserCommand;
use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Exceptions\AlreadyEmailExistException;
use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Exceptions\NotFoundUserException;
use App\Core\User\Domain\WriteUserRepository;

final readonly class UpdateUserHandler
{
    public function __construct(
        private WriteUserRepository $repository,
    ) {}

    /**
     * @throws AlreadyEmailExistException
     * @throws NotFoundUserException
     * @throws NotEmptyException
     */
    public function handle(UpdateUserCommand $command): SaveUserResponse
    {
        $response = new SaveUserResponse;

        $this->checkIfEmailAlreadyExistOrThrowException($command);
        $user = $this->getUserIfExistOrThrowNotFoundException($command->userId);
        $user = $user->update(
            $command->name,
            $command->email,
        );
        $this->repository->update($user->snapshot());

        $response->isSaved = true;
        $response->userId = $user->snapshot()->id;
        $response->code = 201;

        return $response;
    }

    /**
     * @throws AlreadyEmailExistException
     */
    private function checkIfEmailAlreadyExistOrThrowException(UpdateUserCommand $command): void
    {
        if ($this->repository->emailExists($command->email, $command->userId)) {
            throw new AlreadyEmailExistException;
        }
    }

    /**
     * @throws NotFoundUserException
     */
    private function getUserIfExistOrThrowNotFoundException(?string $userId): User
    {
        $eUser = $this->repository->ofId($userId);
        if (is_null($eUser)) {
            throw new NotFoundUserException;
        }

        return $eUser;
    }
}
