<?php

namespace App\Core\Auth\Application\Command\Login;

use App\Core\Auth\Domain\ViewModels\AuthUserViewModel;

class LoginUserResponse
{
    public string $message = '';

    public int $code = 500;

    public ?AuthUserViewModel $authUser = null;

    public function __construct() {}
}
