<?php

namespace App\Core\User\Application\Command\Save;

use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Exceptions\AlreadyEmailExistException;
use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Vo\Hasher;
use App\Core\User\Domain\WriteUserRepository;

final readonly class SaveUserHandler
{
    public function __construct(
        private WriteUserRepository $repository,
        private IdGenerator $idGenerator,
        private Hasher $hasher
    ) {}

    /**
     * @throws AlreadyEmailExistException
     * @throws NotEmptyException
     */
    public function handle(SaveUserCommand $command): SaveUserResponse
    {
        $response = new SaveUserResponse;

        $this->checkIfEmailAlreadyExistOrThrowException($command);
        $user = User::create(
            name: $command->name,
            email: $command->email,
            password: $command->password,
            userId: $this->idGenerator->generate(),
            hasher: $this->hasher
        );
        $this->repository->save($user->snapshot());

        $response->isSaved = true;
        $response->userId = $user->snapshot()->id;

        return $response;
    }

    /**
     * @throws AlreadyEmailExistException
     */
    private function checkIfEmailAlreadyExistOrThrowException(SaveUserCommand $command): void
    {
        if ($this->repository->emailExists($command->email, $command->userId)) {
            throw new AlreadyEmailExistException;
        }
    }
}
