<?php

namespace App\Core\Report\Application\Command\Save;

class SaveReportResponse
{
    public bool $isSaved = false;

    public string $message = '';

    public string $reportId = '';
}
