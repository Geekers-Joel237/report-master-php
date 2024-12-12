<?php

namespace App\Core\User\Application\Query\Profile;

use App\Core\User\Domain\Dto\UserProfileDto;

class UserProfileResponse
{
    public ?UserProfileDto $profile = null;
}
