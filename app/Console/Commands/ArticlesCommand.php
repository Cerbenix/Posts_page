<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Article\Index\IndexArticleService;

class ArticlesCommand
{
    private IndexArticleService $articlesService;

    public function __construct(IndexArticleService $indexArticleService)
    {
        $this->articlesService = $indexArticleService;
    }

    public function execute(): void
    {
        $response = $this->articlesService->execute();

        foreach ($response->getContents() as $content) {
            echo "Article Details:\n";
            echo "[ID]: " . $content->getArticle()->getId() . "\n";
            echo "[Title]: " . $content->getArticle()->getTitle() . "\n";
            echo "[Body]: " . $content->getArticle()->getBody() . "\n";
            echo "[Author]: " . $content->getUser()->getName() . "\n";
            echo "++++++++++++++++++++++++++++++++++++++++++++++\n";
        }
    }
}
