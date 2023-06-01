<?php declare(strict_types=1);

namespace App\Controllers\Article;

use App\Redirect;
use App\Services\Article\Delete\DeleteArticleService;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Views\View;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private DeleteArticleService $deleteArticleService;

    public function __construct(
        IndexArticleService  $indexArticleService,
        ShowArticleService   $showArticleService,
        DeleteArticleService $deleteArticleService)
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->deleteArticleService = $deleteArticleService;
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
            $response = $this->showArticleService->execute($request);
            return new View('article/show', [
                'article' => $response->getArticle(),
                'user' => $response->getUser(),
                'comments' => $response->getComments()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
    public function delete(array $variables): Redirect
    {
        $articleId = (int)$variables['id'];
        $this->deleteArticleService->execute($articleId);
        return new Redirect('/');
    }
}
