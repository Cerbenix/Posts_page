<?php declare(strict_types=1);

namespace App\Services\Article\Modify;

class CreateArticleResponse
{
    private bool $isSaved;

    public function __construct(bool $isSaved)
    {
        $this->isSaved = $isSaved;
    }

    public function getIsSaved(): bool
    {
        return $this->isSaved;
    }
}
