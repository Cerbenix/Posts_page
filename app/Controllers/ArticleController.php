<?php declare(strict_types=1);

namespace App\Controllers;

use App\Cache;
use App\Services\Article\Create\CreateArticleRequest;
use App\Services\Article\Create\CreateArticleService;
use App\Services\Article\Delete\DeleteArticleService;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\Article\Update\UpdateArticleRequest;
use App\Services\Article\Update\UpdateArticleService;
use App\Views\View;

class ArticleController
{
    /**
     * @Inject
     */
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private CreateArticleService $createArticleService;
    private UpdateArticleService $updateArticleService;
    private DeleteArticleService $deleteArticleService;

    public function __construct(
        IndexArticleService  $indexArticleService,
        ShowArticleService   $showArticleService,
        CreateArticleService $createArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService)
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->createArticleService = $createArticleService;
        $this->updateArticleService = $updateArticleService;
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
            return new View('article', [
                'article' => $response->getArticle(),
                'user' => $response->getUser(),
                'comments' => $response->getComments()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }

    public function create(): View
    {
        try {
            if (!empty($_POST['title']) && !empty($_POST['body'])) {
                $request = new CreateArticleRequest($_POST['title'], $_POST['body']);
                $response = $this->createArticleService->execute($request);
                return new View('create', ['result' => $response->getIsSaved()]);
            }
            return new View('create', []);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }

    public function update(array $variables): View
    {
        $articleId = (int)$variables['id'];
        try {
            if (!empty($_POST['title']) && !empty($_POST['body'])) {
                Cache::delete('article_' . $articleId);
                $request = new UpdateArticleRequest($articleId, $_POST['title'], $_POST['body']);
                $response = $this->updateArticleService->execute($request);
                $request = new ShowArticleRequest($articleId);
                $showArticleResponse = $this->showArticleService->execute($request);
                return new View('update',
                    [
                        'result' => $response->getIsUpdated(),
                        'article' => $showArticleResponse->getArticle()
                    ]);
            }
            $request = new ShowArticleRequest($articleId);
            $showArticleResponse = $this->showArticleService->execute($request);
            return new View('update', ['article' => $showArticleResponse->getArticle()]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }

    public function delete(array $variables): void
    {
        $articleId = (int)$variables['id'];
        $this->deleteArticleService->execute($articleId);
        Cache::delete('article_' . $articleId);
        header('Location: /');
    }
}
