<?php

namespace App\Core\User\Infrastructure\Http\Controllers;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use App\Core\User\Application\Command\Delete\DeleteUserHandler;
use App\Core\User\Infrastructure\Factory\UserCommandFactory;
use App\Core\User\Infrastructure\Http\Request\DeleteUserRequest;
use Illuminate\Contracts\Support\Responsable;
use Throwable;

class DeleteUserAction
{
    public function __invoke(
        DeleteUserRequest $request,
        DeleteUserHandler $handler
    ): Responsable {
        try {
            $command = UserCommandFactory::deleteFromRequest($request);
            $response = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'isDeleted' => $response->isDeleted,
                    'message' => $response->message,
                ],
                code: $response->code
            );
        } catch (ApiErrorException|Throwable $e) {
            if ($e instanceof ApiErrorException) {
                return new ApiErrorResponse(
                    message: $e->getMessage(),
                    exception: $e,
                    code: $e->getCode()
                );
            }

            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e
            );
        }
    }
}
