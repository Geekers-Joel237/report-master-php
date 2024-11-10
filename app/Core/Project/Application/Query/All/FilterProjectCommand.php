<?php

namespace App\Core\Project\Application\Query\All;

class FilterProjectCommand
{
    public ?string $year = null;

    public ?string $status = null;

    public function __construct() {}
}
