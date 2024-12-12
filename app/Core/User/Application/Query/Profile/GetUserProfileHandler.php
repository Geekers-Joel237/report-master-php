<?php

namespace App\Core\User\Application\Query\Profile;

use App\Core\User\Domain\Repository\ReadUserRepository;

readonly class GetUserProfileHandler
{
    public function __construct(
        private ReadUserRepository $repository
    ) {}

    public function handle(string $userId): UserProfileResponse
    {
        $response = new UserProfileResponse;
        $response->profile = $this->repository->profile($userId);

        return $response;
    }
}
