<?php declare(strict_types=1);

$container = require_once '../bootstrap.php';

$router = $container->get(\App\Router::class);
$renderer = $container->get(\App\Renderer::class);
$response = $router->response();

if($response instanceof \App\Views\View){
    echo $renderer->render($response);
    unset($_SESSION['errors']);
}
if($response instanceof \App\Redirect){
    header('Location: ' . $response->getLocation());
}