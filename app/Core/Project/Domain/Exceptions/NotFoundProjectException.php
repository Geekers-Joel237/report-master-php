<?php

namespace App\Core\Project\Domain\Exceptions;

use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use App\Core\Shared\Domain\Exceptions\ApiErrorException;
use Throwable;

class NotFoundProjectException extends ApiErrorException
{
    public function __construct(string $message = ProjectMessageEnum::NOT_FOUND_PROJECT, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
