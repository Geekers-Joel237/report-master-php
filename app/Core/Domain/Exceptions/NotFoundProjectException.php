<?php

namespace App\Core\Domain\Exceptions;

use Exception;

class NotFoundProjectException extends Exception
{
    protected $message = 'Ce projet est introuvable !';
}
