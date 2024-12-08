<?php

namespace App\Core\User\Infrastructure\Factory;

use App\Core\User\Application\Command\Save\SaveUserCommand;
use App\Core\User\Application\Command\Save\UpdateUserCommand;
use App\Core\User\Infrastructure\Http\Request\SaveUserRequest;
use App\Core\User\Infrastructure\Http\Request\UpdateUserRequest;

class SaveUserCommandFactory
{
    public static function createFromRequest(SaveUserRequest $request): SaveUserCommand
    {
        $command = new SaveUserCommand(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
        );
        $command->userId = $request->get('userId');

        return $command;
    }

    public static function updateFromRequest(UpdateUserRequest $request): UpdateUserCommand
    {

        return new UpdateUserCommand(
            userId: $request->get('userId'),
            name: $request->get('name'),
            email: $request->get('email'),
        );
    }
}
