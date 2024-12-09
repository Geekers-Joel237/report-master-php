<?php

namespace App\Core\Report\Domain\Exceptions;

use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class ErrorOnSaveReportException extends ApiErrorException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
