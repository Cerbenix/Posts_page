<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$command = $argv[1];
$id = isset($argv[2]) ? (int)$argv[2] : null;

\App\Console\Router::run($command, $id);
