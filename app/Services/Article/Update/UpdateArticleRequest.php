<?php declare(strict_types=1);

namespace App\Services\Article\Update;

class UpdateArticleRequest
{
    private int $articleId;
    private string $title;
    private string $body;

    public function __construct(int $articleId, string $title, string $body)
    {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->body = $body;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}