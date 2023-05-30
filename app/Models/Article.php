<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private int $userId;
    private ?int $id;
    private string $title;
    private string $body;
    private string $createdAt;

    public function __construct(
        int $userId,
        string $title,
        string $body,
        string $createdAt = null,
        ?int $id = null
    )
    {

        $this->userId = $userId;
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt ?? Carbon::now()->format('Y-m-d H:i:s');
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function update(array $attributes): void
    {
        foreach ($attributes as $attribute => $value){
            $this->{$attribute} = $value;
        }
    }
}
