<?php declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DatabaseConnector
{
    private Connection $connection;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['PDO_DB_NAME'],
            'user' => $_ENV['PDO_USER'],
            'password' => $_ENV['PDO_PASSWORD'],
            'host' => $_ENV['PDO_HOST'],
            'driver' => 'pdo_mysql',
        ];
        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}
