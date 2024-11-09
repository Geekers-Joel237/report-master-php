<?php

namespace App\Core\Project\Domain\Exceptions;

use Exception;

class AlreadyExistsProjectWithSameNameException extends Exception {
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
