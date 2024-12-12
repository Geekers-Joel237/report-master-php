<?php

namespace App\Core\User\Infrastructure\Http\Controllers;

use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use App\Core\User\Application\Query\Profile\GetUserProfileHandler;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Throwable;

class GetUserProfileAction
{
    public function __invoke(
        Request $request,
        GetUserProfileHandler $handler,
    ): Responsable {
        try {
            $response = $handler->handle($request->route('userId'));

            return new ApiSuccessResponse(
                data: $response->profile
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e,
            );
        }
    }
}
