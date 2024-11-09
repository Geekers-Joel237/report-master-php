<?php

namespace App\Core\Project\Domain\Exceptions;

use Exception;
use Throwable;

class AlreadyExistsProjectWithSameNameException extends Exception
{
    public function __construct(string $message = '', int $code = 200, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
