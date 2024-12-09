<?php

namespace App\Core\Report\Domain\Exceptions;

use App\Core\Report\Domain\Enums\ReportMessageEnum;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class NotFoundReportException extends ApiErrorException
{
    public function __construct(string $message = ReportMessageEnum::NOT_FOUND_REPORT, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
