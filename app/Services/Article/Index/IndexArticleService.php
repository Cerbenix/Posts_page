<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Services\ApiClient;

class IndexArticleService
{
    private ApiClient $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function execute(): IndexArticleResponse
    {
        $allArticles = $this->apiClient->fetchArticles();
        shuffle($allArticles);
        $articles = array_slice($allArticles, 0, 20);
        $users = $this->apiClient->fetchUsers();
        $contents = $this->apiClient->associateUser($users, $articles);
        return new IndexArticleResponse($contents);
    }
}
