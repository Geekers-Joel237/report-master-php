<?php

namespace App\Core\Report\Application\Command\Delete;

class DeleteReportResponse
{
    public bool $isDeleted = false;

    public string $message = '';

    public int $code = 500;

    public function __construct() {}
}
