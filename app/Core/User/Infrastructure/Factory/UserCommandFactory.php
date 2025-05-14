<?php

namespace App\Core\User\Infrastructure\Factory;

use App\Core\User\Application\Command\Delete\DeleteUserCommand;
use App\Core\User\Application\Command\Save\SaveUserCommand;
use App\Core\User\Application\Command\Update\UpdateUserCommand;
use App\Core\User\Infrastructure\Http\Request\DeleteUserRequest;
use App\Core\User\Infrastructure\Http\Request\SaveUserRequest;
use App\Core\User\Infrastructure\Http\Request\UpdateUserRequest;

class UserCommandFactory
{
    public static function createFromRequest(SaveUserRequest $request): SaveUserCommand
    {
        return new SaveUserCommand(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->get('role')
        );
    }

    public static function updateFromRequest(UpdateUserRequest $request): UpdateUserCommand
    {

        return new UpdateUserCommand(
            userId: $request->route('userId'),
            name: $request->get('name'),
            email: $request->get('email'),
        );
    }

    public static function deleteFromRequest(DeleteUserRequest $request): DeleteUserCommand
    {
        return new DeleteUserCommand(
            userId: $request->route('userId')
        );
    }
}
