<?php declare(strict_types=1);

use App\Controllers\ErrorController;

return [
    ['GET', '/error/{message}', [ErrorController::class, 'print']],
    ['GET', '/', [\App\Controllers\ArticleController::class, 'index']],
    ['GET', '/article', [\App\Controllers\ArticleController::class, 'index']],
    ['GET', '/article/{id:[1-9]|[1-9][0-9]|100}', [\App\Controllers\ArticleController::class, 'show']],
    ['GET', '/article/{id:[1-9]|[1-9][0-9]|100}/edit', [\App\Controllers\ArticleController::class, 'update']],
    ['POST', '/article/{id:[1-9]|[1-9][0-9]|100}/edit', [\App\Controllers\ArticleController::class, 'update']],
    ['GET', '/article/delete/{id:[1-9]|[1-9][0-9]|100}', [\App\Controllers\ArticleController::class, 'delete']],
    ['GET', '/create', [\App\Controllers\ArticleController::class, 'create']],
    ['POST', '/create', [\App\Controllers\ArticleController::class, 'create']],
    ['GET', '/user/{id:[1-9]|10}', [\App\Controllers\UserController::class, 'index']],
];