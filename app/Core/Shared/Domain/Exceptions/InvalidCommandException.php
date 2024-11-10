<?php

namespace App\Core\Shared\Domain\Exceptions;

use Exception;
use Throwable;

class InvalidCommandException extends Exception
{
    public function __construct(string $message = '', int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
