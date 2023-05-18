<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$router = new \App\Router();
$renderer = new \App\Renderer();

echo $renderer->render($router->response());
