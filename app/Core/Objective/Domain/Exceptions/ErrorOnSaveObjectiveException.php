<?php

namespace App\Core\Objective\Domain\Exceptions;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class ErrorOnSaveObjectiveException extends ApiErrorException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
