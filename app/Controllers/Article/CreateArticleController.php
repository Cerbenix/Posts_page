<?php declare(strict_types=1);

namespace App\Controllers\Article;

use App\Redirect;
use App\Services\Article\Create\CreateArticleRequest;
use App\Services\Article\Create\CreateArticleService;
use App\SessionManager;
use App\Views\View;

class CreateArticleController
{
    private CreateArticleService $createArticleService;

    public function __construct(CreateArticleService $createArticleService)
    {
        $this->createArticleService = $createArticleService;
    }

    public function create(): View
    {
        return new View('article/create', []);
    }

    public function store(): Redirect
    {
        try {
            $request = new CreateArticleRequest($_POST['title'], $_POST['body'], SessionManager::get());
            $response = $this->createArticleService->execute($request);
            $article = $response->getArticle();
            return new Redirect('/article/' . $article->getId());
        } catch (\Exception $exception) {
            return new Redirect('/error/' . $exception->getMessage());
        }
    }
}
