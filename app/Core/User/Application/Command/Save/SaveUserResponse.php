<?php

namespace App\Core\User\Application\Command\Save;

class SaveUserResponse
{
    public bool $isSaved = false;

    public string $userId = '';

    public int $code = 500;
}
