<?php

namespace App\Core\Auth\Infrastructure\Http\Controllers;

use App\Core\Auth\Application\Command\Login\LoginUserCommand;
use App\Core\Auth\Application\Service\AuthUserService;
use App\Core\Auth\Infrastructure\Http\Requests\LoginUserRequest;
use App\Core\Shared\Infrastructure\Http\Response\ApiErrorResponse;
use App\Core\Shared\Infrastructure\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Support\Responsable;
use Throwable;

class AuthUserAction
{
    private AuthUserService $authUserService;

    public function __construct(
        AuthUserService $service
    ) {
        $this->authUserService = $service;
    }

    public function login(LoginUserRequest $request): Responsable
    {
        try {
            $command = new LoginUserCommand(
                email: $request->get('email'),
                password: $request->get('password')
            );
            $response = $this->authUserService->login($command);

            return new ApiSuccessResponse(
                data: [
                    'authUser' => $response->authUser,
                ],
                code: $response->code
            );
        } catch (Throwable $e) {

            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e
            );
        }
    }

    public function logout(): Responsable
    {
        try {
            $this->authUserService->logout();

            return new ApiSuccessResponse(
                data: [
                    'message' => 'Déconnexion réussie.',
                ],
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                message: $e->getMessage(),
                exception: $e
            );
        }
    }
}
