<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Cache;
use App\Models\Article;
use App\Models\ArticleUserAssociation;
use GuzzleHttp\Client;

class JsonPlaceholderArticleRepository implements ArticleRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function all(): array
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
            $response = $this->client->get('posts');
            $report = json_decode($response->getBody()->getContents());
            foreach ($report as $article) {
                $articleCollection[] = $this->buildModel($article);
                Cache::save('article_' . $article->id, json_encode($article));
            }
        } else {
            foreach ($articleIdList as $articleId) {
                $cachedReport = json_decode(Cache::get('article_' . $articleId));
                $articleCollection[] = $this->buildModel($cachedReport);
            }
        }
        return $articleCollection;
    }

    public function getById(int $articleId): Article
    {
        $cacheKey = 'article_' . $articleId;
        $report = $this->fetchFromApi('posts/' . $articleId, $cacheKey);
        return $this->buildModel($report);
    }

    public function getByUserId(int $userId): array
    {
        $userArticleCollection = [];
        $cacheKey = 'user_posts_' . $userId;
        $report = $this->fetchFromApi('users/' . $userId . '/posts', $cacheKey);
        foreach ($report as $article) {
            $userArticleCollection[] = $this->buildModel($article);
        }
        return $userArticleCollection;
    }

    public function associateUsers(array $users, array $articles): array
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

    private function buildModel(\stdClass $articleReport): Article
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
            $response = $this->client->get($endpoint);
            $report = (object)json_decode($response->getBody()->getContents());
            Cache::save($cacheKey, json_encode($report));
        } else {
            $report = (object)json_decode(Cache::get($cacheKey));
        }
        return $report;
    }
}
