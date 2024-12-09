<?php

namespace App\Core\Project\Domain\Exceptions;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class ErrorOnSaveProjectException extends ApiErrorException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
