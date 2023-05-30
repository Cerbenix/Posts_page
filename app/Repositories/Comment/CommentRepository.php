<?php declare(strict_types=1);

namespace App\Repositories\Comment;

use App\Models\Comment;

interface CommentRepository
{
    public function getByArticleId(int $articleId): array;

    public function save(Comment $comment): void;

    public function delete(int $commentId): void;
}
