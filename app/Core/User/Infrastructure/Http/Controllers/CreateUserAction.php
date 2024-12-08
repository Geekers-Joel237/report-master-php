<?php

namespace App\Core\User\Infrastructure\Http\Controllers;

use App\Core\User\Application\Command\Save\SaveUserHandler;
use App\Core\User\Infrastructure\Factory\SaveUserCommandFactory;
use App\Core\User\Infrastructure\Http\Request\SaveUserRequest;
use Illuminate\Http\JsonResponse;

class CreateUserAction
{
    public function __invoke(
        SaveUserRequest $request,
        SaveUserHandler $handler
    ): JsonResponse {
        $command = SaveUserCommandFactory::createFromRequest($request);
        $response = $handler->handle($command);

        return new JsonResponse([
            'status' => 201,
            'userId' => $response->userId,
            'isSaved' => $response->isSaved,
        ]);
    }
}
