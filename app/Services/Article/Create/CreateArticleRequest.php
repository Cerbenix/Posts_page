<?php declare(strict_types=1);

namespace App\Services\Article\Create;

class CreateArticleRequest
{
    private string $title;
    private string $body;
    private int $userId;

    public function __construct(string $title, string $body, int $userId)
    {
        $this->title = $title;
        $this->body = $body;
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
