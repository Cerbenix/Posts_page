<?php declare(strict_types=1);

namespace App\Services\Comment\Create;

class CreateCommentRequest
{
    private int $articleId;

    private string $body;
    private int $userId;

    public function __construct(int $articleId, int $userId, string $body)
    {
        $this->articleId = $articleId;
        $this->body = $body;
        $this->userId = $userId;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
