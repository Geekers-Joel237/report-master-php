<?php

namespace App\Core\User\Domain\Exceptions;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class NotFoundUserException extends ApiErrorException
{
    public function __construct(string $message = 'Cet utilisateur est introuvable !', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
