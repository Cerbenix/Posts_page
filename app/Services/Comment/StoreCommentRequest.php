<?php declare(strict_types=1);

namespace App\Services\Comment;

class StoreCommentRequest
{
    private int $articleId;
    private string $name;
    private string $email;
    private string $body;

    public function __construct(int $articleId, string $name, string $email, string $body)
    {

        $this->articleId = $articleId;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
