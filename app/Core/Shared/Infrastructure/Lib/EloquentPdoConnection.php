<?php

namespace App\Core\Shared\Infrastructure\Lib;

use App\Core\Shared\Lib\PdoConnection;
use Illuminate\Support\Facades\DB;
use PDO;

class EloquentPdoConnection implements PdoConnection
{

    public function getPdo(): PDO
    {
       return DB::connection('mysql')->getPdo();
    }
}
