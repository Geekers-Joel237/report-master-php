<?php

namespace App\Core\Project\Domain\Exceptions;

use Exception;

class NotFoundProjectException extends Exception
{
    protected $message = 'Ce projet est introuvable !';
}
