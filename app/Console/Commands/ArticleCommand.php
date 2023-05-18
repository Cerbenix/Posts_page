<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;

class ArticleCommand
{
    private ShowArticleService $articleService;

    public function __construct()
    {
        $this->articleService = new ShowArticleService();
    }

    public function execute(int $articleId): void
    {
        $response = $this->articleService->execute(new ShowArticleRequest($articleId));

        echo "Article Details:\n";
        echo "[ID]: " . $response->getArticle()->getId() . "\n";
        echo "[Title]: " . $response->getArticle()->getTitle() . "\n";
        echo "[Body]: " . $response->getArticle()->getBody() . "\n";
        echo "[Author]: " . $response->getUser()->getName() . "\n";
        echo "++++++++++++++++++++++++++++++++++++++++++++++\n";
        foreach ($response->getComments() as $comment) {
            echo "[Comment]: " . $comment->getBody() . "\n";
            echo "[Comment Author]: " . $comment->getName() . "\n";
            echo "[Author Email]: " . $comment->getEmail() . "\n";
            echo "++++++++++++++++++++++++++++++++++++++++++++++\n";
        }

    }
}
