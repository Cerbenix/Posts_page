<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Models\Comment;
use App\Services\ApiClient;

class ShowArticleService
{
    private ApiClient $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->apiClient->fetchArticle($request->getArticleId());
        $userId = $article->getUserId();
        $user = $this->apiClient->fetchUser($userId);
        $comments = $this->apiClient->fetchArticleComments($request->getArticleId());
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['body'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $body = $_POST['body'];
            $comments[] = new Comment($request->getArticleId(), count($comments) + 1, $name, $email, $body);
        }
        return new ShowArticleResponse($article, $user, $comments);
    }
}
