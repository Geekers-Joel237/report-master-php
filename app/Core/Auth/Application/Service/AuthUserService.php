<?php

namespace App\Core\Auth\Application\Service;

use App\Core\Auth\Application\Command\Login\LoginUserCommand;
use App\Core\Auth\Application\Command\Login\LoginUserResponse;
use App\Core\Auth\Infrastructure\ViewModels\AuthUserViewModel;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use App\Core\User\Infrastructure\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthUserService
{
    public function login(LoginUserCommand $command): LoginUserResponse
    {
        $response = new LoginUserResponse;
        $user = User::query()->where('email', $command->email)->first();

        if (! $user || ! Hash::check($command->password, $user->password)) {
            $response->message = 'Les identifiants sont incorrects.';
            $response->code = 401;

            return $response;
        }

        // Révocation des tokens existants (optionnel)
        $user->tokens()->delete();

        $authUser = new AuthUserViewModel(
            userId: $user->id,
            name: $user->name,
            email: $user->email,
            roleId: $user->roles()->first()->id,
            roleName: $user->roles()->first()->name,
            token: $user->createToken(config('auth.api_token'))->plainTextToken
        );

        $response->code = 200;
        $response->message = 'Connexion réussie !';
        $response->authUser = $authUser;

        return $response;
    }

    public function logout(): void
    {
        auth()->user()->tokens()->delete();

    }

    /**
     * @throws ApiErrorException
     */
    public function token(string $tokenableId): string
    {
        try {
            return User::query()->find($tokenableId)->createToken(config('auth.api_token'))->plainTextToken;
        } catch (Throwable $th) {
            throw new ApiErrorException('Error occurred while trying to create token');
        }

    }
}
