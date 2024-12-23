<?php

namespace App\Core\User\Application\Command\Save;

use App\Core\ACL\Domain\Enums\RoleEnum;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\Shared\Domain\IdGenerator;
use App\Core\User\Domain\Entities\User;
use App\Core\User\Domain\Exceptions\AlreadyEmailExistException;
use App\Core\User\Domain\Exceptions\ErrorOnSaveUserException;
use App\Core\User\Domain\Exceptions\NotEmptyException;
use App\Core\User\Domain\Repository\WriteUserRepository;
use App\Core\User\Domain\Vo\Hasher;

final readonly class SaveUserHandler
{
    public function __construct(
        private WriteUserRepository $repository,
        private IdGenerator $idGenerator,
        private Hasher $hasher,
    ) {}

    /**
     * @throws AlreadyEmailExistException
     * @throws InvalidCommandException
     * @throws NotEmptyException
     * @throws ErrorOnSaveUserException
     */
    public function handle(SaveUserCommand $command): SaveUserResponse
    {
        $response = new SaveUserResponse;

        $role = RoleEnum::in($command->role);
        $this->checkIfEmailAlreadyExistOrThrowException($command);
        $user = User::create(
            name: $command->name,
            email: $command->email,
            password: $command->password,
            userId: $this->idGenerator->generate(),
            hasher: $this->hasher,
            role: $role
        );
        $this->repository->save($user->snapshot());

        $response->isSaved = true;
        $response->userId = $user->snapshot()->id;
        $response->code = 201;

        return $response;
    }

    /**
     * @throws AlreadyEmailExistException
     */
    private function checkIfEmailAlreadyExistOrThrowException(SaveUserCommand $command): void
    {
        if ($this->repository->emailExists($command->email, null)) {
            throw new AlreadyEmailExistException;
        }
    }
}
