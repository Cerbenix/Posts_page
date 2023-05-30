<?php declare(strict_types=1);

namespace App\Models;

class Comment
{
    private int $postId;
    private string $name;
    private string $email;
    private string $body;
    private ?int $id;

    public function __construct(
        int $postId,
        string $name,
        string $email,
        string $body,
        ?int $id = null
    )
    {
        $this->postId = $postId;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
}
