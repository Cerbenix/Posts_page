<?php declare(strict_types=1);

namespace App\Services;

use App\Cache;
use App\Models\Article;
use App\Models\ArticleUserAssociation;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use GuzzleHttp\Client;

class ApiClient
{
    private Client $apiClient;

    public function __construct()
    {
        $this->apiClient = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function fetchArticles(): array
    {
        $articleCollection = [];
        $articleIdList = range(1, 100);
        $allCached = true;
        foreach ($articleIdList as $articleId) {
            if (!Cache::has('article_' . $articleId)) {
                $allCached = false;
                break;
            }
        }
        if (!$allCached) {
            $response = $this->apiClient->get('posts');
            $report = json_decode($response->getBody()->getContents());
            foreach ($report as $article) {
                $articleCollection[] = $this->createArticle($article);
                Cache::save('article_' . $article->id, json_encode($article));
            }
        } else {
            foreach ($articleIdList as $articleId) {
                $cachedReport = json_decode(Cache::get('article_' . $articleId));
                $articleCollection[] = $this->createArticle($cachedReport);
            }
        }
        return $articleCollection;
    }

    public function fetchArticle(int $articleId): Article
    {
        $cacheKey = 'article_' . $articleId;
        $report = $this->fetchFromApi('posts/' . $articleId, $cacheKey);
        return $this->createArticle($report);
    }

    public function fetchUsers(): array
    {
        $userCollection = [];
        $userIdList = range(1, 10);
        $allCached = true;
        foreach ($userIdList as $userId) {
            if (!Cache::has('user_' . $userId)) {
                $allCached = false;
                break;
            }
        }
        if (!$allCached) {
            $response = $this->apiClient->get('users');
            $report = json_decode($response->getBody()->getContents());
            foreach ($report as $user) {
                $userCollection[] = $this->createUser($user);
                Cache::save('user_' . $user->id, json_encode($user));
            }
        } else {
            foreach ($userIdList as $userId) {
                $cachedReport = json_decode(Cache::get('user_' . $userId));
                $userCollection[] = $this->createUser($cachedReport);
            }
        }
        return $userCollection;
    }

    public function fetchUser(int $userId): User
    {
        $cacheKey = 'user_' . $userId;
        $report = $this->fetchFromApi('users/' . $userId, $cacheKey);
        return $this->createUser($report);
    }

    public function fetchUserArticles(int $userId): array
    {
        $userArticleCollection = [];
        $cacheKey = 'user_posts_' . $userId;
        $report = $this->fetchFromApi('users/' . $userId . '/posts', $cacheKey);
        foreach ($report as $article) {
            $userArticleCollection[] = $this->createArticle($article);
        }
        return $userArticleCollection;
    }

    public function fetchArticleComments(int $articleId): array
    {
        $commentCollection = [];
        $cacheKey = 'comments_for_article_' . $articleId;
        $report = $this->fetchFromApi('posts/' . $articleId . '/comments', $cacheKey);
        foreach ($report as $comment) {
            $commentCollection[] = $this->createComment($comment);
        }
        return $commentCollection;
    }

    public function associateUser(array $users, array $articles): array
    {
        $associatedList = [];
        foreach ($articles as $article) {
            foreach ($users as $user) {
                if ($article->getUserId() == $user->getId()) {
                    $associatedList[] = new ArticleUserAssociation($article, $user);
                }
            }
        }
        return $associatedList;
    }

    private function createComment(\stdClass $commentReport): Comment
    {
        return new Comment(
            $commentReport->postId,
            $commentReport->id,
            $commentReport->name,
            $commentReport->email,
            $commentReport->body
        );
    }

    private function createUser(\stdClass $userReport): User
    {
        return new User(
            $userReport->id,
            $userReport->name,
            $userReport->username,
            $userReport->email,
            $this->createAddress($userReport->address),
            $userReport->phone,
            $userReport->website,
            $this->createCompany($userReport->company)
        );
    }

    private function createCompany(\stdClass $companyReport): UserCompany
    {
        return new UserCompany(
            $companyReport->name,
            $companyReport->catchPhrase,
            $companyReport->bs
        );
    }

    private function createAddress(\stdClass $addressReport): UserAddress
    {
        return new UserAddress(
            $addressReport->street,
            $addressReport->suite,
            $addressReport->city,
            $addressReport->zipcode
        );
    }

    private function createArticle(\stdClass $articleReport): Article
    {
        return new Article(
            $articleReport->userId,
            $articleReport->id,
            $articleReport->title,
            $articleReport->body,
        );
    }

    private function fetchFromApi(string $endpoint, string $cacheKey): \stdClass
    {
        if (!Cache::has($cacheKey)) {
            $response = $this->apiClient->get($endpoint);
            $report = (object)json_decode($response->getBody()->getContents());
            Cache::save($cacheKey, json_encode($report));
        } else {
            $report = (object)json_decode(Cache::get($cacheKey));
        }
        return $report;
    }
}
