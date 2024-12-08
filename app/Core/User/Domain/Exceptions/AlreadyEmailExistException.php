<?php

namespace App\Core\User\Domain\Exceptions;

use Exception;
use Throwable;

class AlreadyEmailExistException extends Exception
{
    public function __construct(string $message = 'Cet email existe déjà !', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
