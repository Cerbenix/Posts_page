<?php declare(strict_types=1);

use App\Controllers\ErrorController;

return [
    ['GET', '/error/{message}', [ErrorController::class, 'print']],
    ['GET', '/', [\App\Controllers\PlaceholderController::class, 'index']],
    ['GET', '/article', [\App\Controllers\PlaceholderController::class, 'index']],
    ['GET', '/article/{id:[1-9]|[1-9][0-9]|100}', [\App\Controllers\PlaceholderController::class, 'article']],
    ['GET', '/user/{id:[1-9]|10}', [\App\Controllers\PlaceholderController::class, 'user']],
];