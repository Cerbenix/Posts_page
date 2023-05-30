<?php declare(strict_types=1);

namespace App\Controllers\Article;

use App\Services\Article\Create\CreateArticleRequest;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\Article\Update\UpdateArticleRequest;
use App\Services\Article\Update\UpdateArticleService;
use App\Views\View;

class UpdateArticleController
{
    private UpdateArticleService $updateArticleService;
    private ShowArticleService $showArticleService;

    public function __construct(
        UpdateArticleService $updateArticleService,
        ShowArticleService   $showArticleService
    )
    {
        $this->updateArticleService = $updateArticleService;
        $this->showArticleService = $showArticleService;
    }

    public function edit(array $variables): View
    {
        $articleId = (int)$variables['id'];
        $request = new ShowArticleRequest($articleId);
        $response = $this->showArticleService->execute($request);
        return new View('article/update', ['article' => $response->getArticle()]);
    }

    public function update(array $variables): void
    {
        $articleId = (int)$variables['id'];
        $request = new UpdateArticleRequest($articleId, $_POST['title'], $_POST['body']);
        $response = $this->updateArticleService->execute($request);
        $article = $response->getArticle();
        header('Location: /article/' . $article->getId() . '/edit');
    }
}
