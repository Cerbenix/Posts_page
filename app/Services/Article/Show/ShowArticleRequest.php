<?php declare(strict_types=1);

namespace App\Services\Article\Show;

class ShowArticleRequest
{
    private int $articleId;
    private ?string $commentName = null;
    private ?string $commentEmail = null;
    private ?string $commentBody = null;

    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function setCommentName(?string $commentName): void
    {
        $this->commentName = $commentName;
    }

    public function setCommentEmail(?string $commentEmail): void
    {
        $this->commentEmail = $commentEmail;
    }

    public function setCommentBody(?string $commentBody): void
    {
        $this->commentBody = $commentBody;
    }

    public function getCommentName(): ?string
    {
        return $this->commentName;
    }

    public function getCommentEmail(): ?string
    {
        return $this->commentEmail;
    }

    public function getCommentBody(): ?string
    {
        return $this->commentBody;
    }
}
