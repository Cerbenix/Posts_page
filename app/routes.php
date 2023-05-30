<?php declare(strict_types=1);

use App\Controllers\ErrorController;

return [
    //Error
    ['GET', '/error/{message}', [ErrorController::class, 'print']],

    //Article Index
    ['GET', '/', [\App\Controllers\Article\ArticleController::class, 'index']],
    ['GET', '/article', [\App\Controllers\Article\ArticleController::class, 'index']],

    //Article Show
    ['GET', '/article/{id:\d+}', [\App\Controllers\Article\ArticleController::class, 'show']],

    //Article Edit
    ['GET', '/article/{id:\d+}/edit', [\App\Controllers\Article\UpdateArticleController::class, 'edit']],
    ['POST', '/article/{id:\d+}', [\App\Controllers\Article\UpdateArticleController::class, 'update']],

    //Article Delete
    ['GET', '/article/delete/{id:\d+}', [\App\Controllers\Article\ArticleController::class, 'delete']],

    //Article Create
    ['GET', '/article/create', [\App\Controllers\Article\CreateArticleController::class, 'create']],
    ['POST', '/article', [\App\Controllers\Article\CreateArticleController::class, 'store']],

    //Comment Create
    ['POST', '/article/{id:\d+}/comment', [\App\Controllers\CommentController::class, 'store']],

    //Comment Delete
    ['GET', '/article/{id:\d+}/comment/{commentId}/delete', [\App\Controllers\CommentController::class, 'delete']],

    //User Index
    ['GET', '/user/{id:\d+}', [\App\Controllers\User\UserController::class, 'show']],

    //User Profile
    ['GET', '/profile', [\App\Controllers\User\UserController::class, 'profile']],

    //User Edit
    ['GET', '/profile/edit', [\App\Controllers\User\UpdateUserController::class, 'edit']],
    ['POST', '/profile', [\App\Controllers\User\UpdateUserController::class, 'update']],

    //User Register
    ['GET', '/user/register', [\App\Controllers\User\RegisterUserController::class, 'register']],
    ['POST', '/user', [\App\Controllers\User\RegisterUserController::class, 'store']],

    //User Login
    ['GET', '/login', [\App\Controllers\User\AuthenticateUserController::class, 'show']],
    ['POST', '/login', [\App\Controllers\User\AuthenticateUserController::class, 'login']],
    ['GET', '/logout', [\App\Controllers\User\AuthenticateUserController::class, 'logout']],
];