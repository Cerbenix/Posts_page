<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Cache;
use App\DatabaseConnector;
use App\Models\Article;
use App\Models\ArticleUserAssociation;
use Doctrine\DBAL\Query\QueryBuilder;


class PdoArticleRepository implements ArticleRepository
{
    private DatabaseConnector $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->connection = new DatabaseConnector();
        $this->queryBuilder = $this->connection->getConnection()->createQueryBuilder();
    }

    public function all(): array
    {
        $articleCollection = [];
        $articleAmount = $this->queryBuilder->select('COUNT(*)')
            ->from('articles')
            ->fetchNumeric();
        $articleIdList = range(1, $articleAmount[0]);
        $allCached = true;
        foreach ($articleIdList as $articleId) {
            if (!Cache::has('article_' . $articleId)) {
                $allCached = false;
                break;
            }
        }
        if (!$allCached) {
            $articles = $this->queryBuilder->select('*')
                ->from('articles')
                ->fetchAllAssociative();
            foreach ($articles as $article) {
                $articleCollection[] = $this->buildModel($article);
                Cache::save('article_' . $article['id'], json_encode($article));
            }
        } else {
            foreach ($articleIdList as $articleId) {
                $cachedReport = json_decode(Cache::get('article_' . $articleId));
                $articleCollection[] = $this->buildModel((array)$cachedReport);
            }
        }
        return $articleCollection;
    }

    public function getById(int $articleId): Article
    {
        $cacheKey = 'article_' . $articleId;
        if (!Cache::has($cacheKey)) {
            $article = $this->queryBuilder->select('*')
                ->from('articles')
                ->where("id = $articleId")
                ->fetchAssociative();
            Cache::save($cacheKey, json_encode($article));
        } else {
            $article = json_decode(Cache::get($cacheKey));
        }
        return $this->buildModel((array)$article);
    }

    public function getByUserId(int $userId): array
    {
        $userArticleCollection = [];
        $cacheKey = 'user_articles_' . $userId;
        if (!Cache::has($cacheKey)) {
            $articles = $this->queryBuilder->select('*')
                ->from('articles')
                ->where("user_id = $userId")
                ->fetchAllAssociative();
            Cache::save($cacheKey, json_encode($articles));
            foreach ($articles as $article) {
                $userArticleCollection[] = $this->buildModel($article);
            }
        } else {
            $articles = json_decode(Cache::get($cacheKey));
            foreach ($articles as $article) {
                $userArticleCollection[] = $this->buildModel((array)$article);
            }
        }
        return $userArticleCollection;
    }

    public function associateUsers(array $users, array $articles): array
    {
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user->getId()] = $user;
        }
        $associatedList = [];
        foreach ($articles as $article) {
            $userId = $article->getUserId();
            if (isset($usersById[$userId])) {
                $user = $usersById[$userId];
                $associatedList[] = new ArticleUserAssociation($article, $user);
            }
        }
        return $associatedList;
    }

    public function create(string $title, string $body): bool
    {
        try {
            $this->connection->getConnection()->insert(
                'articles',
                [
                    'user_id' => 1,
                    'title' => $title,
                    'body' => $body
                ]);
            return true;
        } catch (\Doctrine\DBAL\Exception $e) {
            return false;
        }
    }

    public function update(int $articleId, string $title, string $body): bool
    {
        try {
            Cache::delete('article_' . $articleId);
            $this->connection->getConnection()->update(
                'articles',
                [
                    'title' => $title,
                    'body' => $body
                ],
                [
                    'id' => $articleId
                ]);
            return true;
        } catch (\Doctrine\DBAL\Exception $e) {
            return false;
        }
    }

    public function delete(int $articleId): void
    {
        $this->connection->getConnection()->delete('articles', ['id' => $articleId]);
        Cache::delete('article_' . $articleId);
    }

    private function buildModel(array $articleReport): Article
    {
        return new Article(
            (int)$articleReport['user_id'],
            (int)$articleReport['id'],
            $articleReport['title'],
            $articleReport['body'],
        );
    }
}
