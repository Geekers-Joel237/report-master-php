<?php

namespace App\Core\Auth\Application\Command\Login;

use App\Core\Auth\Infrastructure\ViewModels\AuthUserViewModel;

class LoginUserResponse
{
    public string $message = '';

    public int $code = 500;

    public ?AuthUserViewModel $authUser = null;

    public function __construct() {}
}
