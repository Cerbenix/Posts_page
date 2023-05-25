<?php declare(strict_types=1);

namespace App\Services\Comment;

class DeleteCommentRequest
{
    private int $articleId;
    private int $commentId;

    public function __construct(int $articleId, int $commentId)
    {
        $this->articleId = $articleId;
        $this->commentId = $commentId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getCommentId(): int
    {
        return $this->commentId;
    }
}
