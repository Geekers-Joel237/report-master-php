<?php

namespace App\Core\User\Domain\Exceptions;

use Exception;
use Throwable;

class NotFoundUserException extends Exception
{
    public function __construct(string $message = 'Cet utilisateur est introuvable !', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
