<?php declare(strict_types=1);

use App\Controllers\ErrorController;

return [
    ['GET', '/error/{message}', [ErrorController::class, 'print']],
    ['GET', '/', [\App\Controllers\ArticleController::class, 'index']],
    ['GET', '/article', [\App\Controllers\ArticleController::class, 'index']],
    ['GET', '/article/{id}', [\App\Controllers\ArticleController::class, 'show']],
    ['GET', '/article/{id}/edit', [\App\Controllers\ArticleController::class, 'update']],
    ['POST', '/article/{id}/edit', [\App\Controllers\ArticleController::class, 'update']],
    ['GET', '/article/delete/{id}', [\App\Controllers\ArticleController::class, 'delete']],
    ['POST', '/article/{id}/comment', [\App\Controllers\CommentController::class, 'store']],
    ['GET', '/article/{id}/comment/{commentId}/delete', [\App\Controllers\CommentController::class, 'delete']],
    ['GET', '/create', [\App\Controllers\ArticleController::class, 'create']],
    ['POST', '/create', [\App\Controllers\ArticleController::class, 'create']],
    ['GET', '/user/{id}', [\App\Controllers\UserController::class, 'index']],
];