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
            $request = new ShowArticleRequest($articleId);
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['body'])) {
                $request->setCommentName($_POST['name']);
                $request->setCommentEmail($_POST['email']);
                $request->setCommentBody($_POST['body']);
            }
            $response = $service->execute($request);
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
