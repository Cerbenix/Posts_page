<?php declare(strict_types=1);

namespace App\Services\Article\Modify;

class UpdateArticleResponse
{
    private bool $isUpdated;

    public function __construct(bool $isUpdated)
    {
        $this->isUpdated = $isUpdated;
    }

    public function getIsUpdated(): bool
    {
        return $this->isUpdated;
    }
}
