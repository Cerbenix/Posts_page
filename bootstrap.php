<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use DI\ContainerBuilder;

\App\SessionManager::start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$container = $containerBuilder->build();

return $container;