<?php declare(strict_types=1);

$container = require_once '../bootstrap.php';

$router = $container->get(\App\Router::class);
$renderer = $container->get(\App\Renderer::class);

echo $renderer->render($router->response());
