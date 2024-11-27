<?php

namespace App\Core\Objective\Domain\Exceptions;

use App\Core\Objective\Domain\Enums\ObjectiveMessageEnum;
use Exception;
use Throwable;

class NotFoundObjectiveException extends Exception
{
    public function __construct(string $message = ObjectiveMessageEnum::NOT_FOUND_OBJECTIVE, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
