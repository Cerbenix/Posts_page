<?php declare(strict_types=1);

namespace App\Controllers;


use App\Models\Comment;
use App\Services\ApiClient;
use App\Views\View;

class PlaceholderController
{
    private ApiClient $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function index(): View
    {
        $allArticles = $this->apiClient->fetchArticles();
        shuffle($allArticles);
        $articles = array_slice($allArticles, 0, 20);
        $users = $this->apiClient->fetchUsers();
        $contents = $this->apiClient->associateUser($users, $articles);
        return new View('index', ['contents' => $contents]);
    }

    public function article(array $variables): View
    {
        $articleId = $variables['id'];
        $article = $this->apiClient->fetchArticle($articleId);
        $userId = $article->getUserId();
        $user = $this->apiClient->fetchUser((string)$userId);
        $comments = $this->apiClient->fetchArticleComments($articleId);
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['body'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $body = $_POST['body'];
            $comments[] = new Comment((int)$articleId, count($comments) + 1, $name, $email, $body);
        }
        return new View('article', [
            'article' => $article,
            'user' => $user,
            'comments' => $comments
        ]);
    }

    public function user(array $variables): View
    {
        $userId = $variables['id'];
        $user = $this->apiClient->fetchUser($userId);
        $userArticles = $this->apiClient->fetchUserArticles($userId);
        return new View('user', [
            'user' => $user,
            'userArticles' => $userArticles
        ]);
    }
}
