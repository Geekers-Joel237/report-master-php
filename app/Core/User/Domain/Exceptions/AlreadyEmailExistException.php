<?php

namespace App\Core\User\Domain\Exceptions;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class AlreadyEmailExistException extends ApiErrorException
{
    public function __construct(string $message = 'Cet email existe déjà !', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
