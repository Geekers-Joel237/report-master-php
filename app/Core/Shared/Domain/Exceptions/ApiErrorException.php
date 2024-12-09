<?php

namespace App\Core\Shared\Domain\Exceptions;

use Exception;
use Throwable;

class ApiErrorException extends Exception
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
