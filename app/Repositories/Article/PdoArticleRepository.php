<?php declare(strict_types=1);

namespace App\Repositories\Article;

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
        $articles = $this->queryBuilder->select('*')
            ->from('articles')
            ->fetchAllAssociative();
        foreach ($articles as $article) {
            $articleCollection[] = $this->buildModel($article);
        }
        return $articleCollection;
    }

    public function getById(int $articleId): Article
    {
        $article = $this->queryBuilder->select('*')
            ->from('articles')
            ->where("id = ?")
            ->setParameter(0, $articleId)
            ->fetchAssociative();
        return $this->buildModel((array)$article);
    }

    public function getByUserId(int $userId): array
    {
        $userArticleCollection = [];
        $articles = $this->queryBuilder->select('*')
            ->from('articles')
            ->where("user_id = ?")
            ->setParameter(0, $userId)
            ->fetchAllAssociative();
        foreach ($articles as $article) {
            $userArticleCollection[] = $this->buildModel($article);
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

    public function save(Article $article): void
    {
        $this->queryBuilder->insert('articles')
            ->values(
                [
                    'title' => '?',
                    'user_id' => '?',
                    'body' => '?',
                    'created_at' => '?',
                ]
            )
            ->setParameter(0, $article->getTitle())
            ->setParameter(1, $article->getUserId())
            ->setParameter(2, $article->getBody())
            ->setParameter(3, $article->getCreatedAt())
            ->executeQuery();
        $article->setId((int)$this->connection->getConnection()->lastInsertId());
    }

    public function update(Article $article): void
    {
        $this->queryBuilder->update('articles')
            ->set('title', '?')
            ->set('body', '?')
            ->where('id = ?')
            ->setParameter(0, $article->getTitle())
            ->setParameter(1, $article->getBody())
            ->setParameter(2, $article->getId())
            ->executeStatement();
    }

    public function delete(int $articleId): void
    {
        $this->connection->getConnection()->delete('articles', ['id' => $articleId]);
    }

    private function buildModel(array $articleReport): Article
    {
        return new Article(
            (int)$articleReport['user_id'],
            $articleReport['title'],
            $articleReport['body'],
            $articleReport['created_at'],
            (int)$articleReport['id'],
        );
    }
}
