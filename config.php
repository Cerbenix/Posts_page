<?php declare(strict_types=1);

return [
    \App\Repositories\Article\ArticleRepository::class => new \App\Repositories\Article\PdoArticleRepository(),
    \App\Repositories\User\UserRepository::class => new \App\Repositories\User\JsonPlaceholderUserRepository,
    \App\Repositories\Comment\CommentRepository::class => new \App\Repositories\Comment\PdoCommentRepository(),
    ];

