<?php declare(strict_types=1);

$container = require_once 'bootstrap.php';

$router = $container->get(\App\Console\Router::class);

$command = $argv[1];
$id = isset($argv[2]) ? (int)$argv[2] : null;

$router->run($command, $id);
