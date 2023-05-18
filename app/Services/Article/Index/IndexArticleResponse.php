<?php declare(strict_types=1);

namespace App\Services\Article\Index;

class IndexArticleResponse
{
    private array $content;

    public function __construct(array $contents)
    {

        $this->content = $contents;
    }

    public function getContents(): array
    {
        return $this->content;
    }

}