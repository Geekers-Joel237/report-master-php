<?php

namespace Tests\Feature;


use Testcontainer\Container\MySQLContainer;

class MySqlTestContainer
{
    private MySQLContainer $container;

    public function __construct()
    {
        $this->container = MySQLContainer::make(version: '8.0')
            ->withMySQLDatabase(database: 'report-master')
            ->withMySQLUser(username: 'user', password: 'password')
            ->withPort(localPort: '3307', containerPort: '3306');

    }

    public function start(): void
    {
        $this->container->run();
        $this->setupLaravelEnv();
    }

    public function stop(): void
    {
        $this->container->stop();
    }

    private function setupLaravelEnv(): void
    {

        /*error_log('Setting up Laravel environment for integration tests.');
        Config::set([
            'database.connections.mysql.host' => $this->container->getAddress(),
            'database.connections.mysql.port' => 3307,
            'database.connections.mysql.database' => 'report-master',
            'database.connections.mysql.username' => 'user',
            'database.connections.mysql.password' => 'password',
        ]);

        $process = new Process(['php', 'artisan', 'migrate']);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }*/
    }
}
