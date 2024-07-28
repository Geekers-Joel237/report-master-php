<?php

use Tests\Feature\MySqlTestContainer;

require __DIR__.'/../../vendor/autoload.php';

$mysqlContainer = new MySQLTestContainer;
$mysqlContainer->start();

register_shutdown_function(function () use ($mysqlContainer) {
    $mysqlContainer->stop();
});
