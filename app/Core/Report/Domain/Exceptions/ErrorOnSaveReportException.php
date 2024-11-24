<?php

namespace App\Core\Report\Domain\Exceptions;

class ErrorOnSaveReportException
{

    /**
     * @param string $getMessage
     */
    public function __construct(string $getMessage)
    {
    }
}
