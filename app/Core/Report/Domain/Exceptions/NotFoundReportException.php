<?php

namespace App\Core\Report\Domain\Exceptions;

use App\Core\Report\Domain\Enums\ReportMessageEnum;
use Exception;
use Throwable;

class NotFoundReportException extends Exception
{
    public function __construct(string $message = ReportMessageEnum::NOT_FOUND_REPORT, int $code = 404, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
