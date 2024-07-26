<?php

namespace App\Core\Project\Domain\Exceptions;

use App\Core\Project\Domain\Enums\ProjectMessageEnum;
use Exception;
use Throwable;

class NotFoundProjectException extends Exception
{
    public function __construct(string $message = ProjectMessageEnum::NOT_FOUND_PROJECT, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
