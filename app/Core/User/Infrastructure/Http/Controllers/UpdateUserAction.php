<?php

namespace App\Core\User\Infrastructure\Http\Controllers;

use App\Core\User\Application\Command\Update\UpdateUserHandler;
use App\Core\User\Infrastructure\Factory\SaveUserCommandFactory;
use App\Core\User\Infrastructure\Http\Request\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UpdateUserAction
{
    public function __invoke(
        UpdateUserRequest $request,
        UpdateUserHandler $handler
    ): JsonResponse {
        $command = SaveUserCommandFactory::updateFromRequest($request);
        $response = $handler->handle($command);

        return new JsonResponse([
            'status' => 200,
            'userId' => $response->userId,
            'isSaved' => $response->isSaved,
        ]);
    }
}
