<?php declare(strict_types=1);

return [
    'articleRepository' => \DI\create(\App\Repositories\Article\JsonPlaceholderArticleRepository::class),
    'userRepository' => \DI\create(\App\Repositories\User\JsonPlaceholderUserRepository::class),
    'commentRepository' => \DI\create(\App\Repositories\Comment\JsonPlaceholderCommentRepository::class),

    ];

