<?php

namespace App\Core\Report\Domain\Exceptions;

use Exception;

class ErrorOnSaveReportException extends Exception
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
