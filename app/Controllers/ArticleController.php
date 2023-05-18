<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Views\View;

class ArticleController
{
    public function index(): View
    {
        try {
            $service = new IndexArticleService();
            $response = $service->execute();
            return new View('index', ['contents' => $response->getContents()]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }

    public function show(array $variables): View
    {
        try {
            $articleId = (int)$variables['id'];
            $service = new ShowArticleService();
            $response = $service->execute(new ShowArticleRequest($articleId));
            return new View('article', [
                'article' => $response->getArticle(),
                'user' => $response->getUser(),
                'comments' => $response->getComments()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
}
