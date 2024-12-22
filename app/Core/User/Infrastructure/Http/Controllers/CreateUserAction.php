<?php

namespace App\Core\User\Infrastructure\Http\Controllers;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use App\Core\User\Application\Command\Save\SaveUserHandler;
use App\Core\User\Infrastructure\Factory\UserCommandFactory;
use App\Core\User\Infrastructure\Http\Request\SaveUserRequest;
use Illuminate\Contracts\Support\Responsable;
use Throwable;

class CreateUserAction
{
    public function __invoke(
        SaveUserRequest $request,
        SaveUserHandler $handler
    ): Responsable {
        try {

            $command = UserCommandFactory::createFromRequest($request);
            $response = $handler->handle($command);

            return new ApiSuccessResponse(
                data: [
                    'userId' => $response->userId,
                    'isSaved' => $response->isSaved,
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
