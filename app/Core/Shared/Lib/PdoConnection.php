<?php

namespace App\Core\Shared\Lib;

use PDO;

interface PdoConnection
{
    public function getPdo(): PDO;
}
