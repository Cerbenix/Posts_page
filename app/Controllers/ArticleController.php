<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Views\View;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        ShowArticleService $showArticleService)
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
    }

    public function index(): View
    {
        try {
            $response = $this->indexArticleService->execute();
            return new View('index', ['contents' => $response->getContents()]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }

    public function show(array $variables): View
    {
        try {
            $articleId = (int)$variables['id'];
            $request = new ShowArticleRequest($articleId);
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['body'])) {
                $request->setCommentName($_POST['name']);
                $request->setCommentEmail($_POST['email']);
                $request->setCommentBody($_POST['body']);
            }
            $response = $this->showArticleService->execute($request);
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
