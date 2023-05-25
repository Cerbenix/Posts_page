<?php declare(strict_types=1);

namespace App\Repositories\Comment;

use App\Cache;
use App\DatabaseConnector;
use App\Models\Comment;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoCommentRepository implements CommentRepository
{
    private DatabaseConnector $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->connection = new DatabaseConnector();
        $this->queryBuilder = $this->connection->getConnection()->createQueryBuilder();
    }

    public function getByArticleId(int $articleId): array
    {
        $commentCollection = [];
        $cacheKey = 'comments_for_article_' . $articleId;
        if (!Cache::has($cacheKey)) {
            $comments = $this->queryBuilder->select('*')
                ->from('comments')
                ->where("article_id = $articleId")
                ->fetchAllAssociative();
            Cache::save($cacheKey, json_encode($comments));
        } else {
            $comments = json_decode(Cache::get($cacheKey));
        }
        foreach ($comments as $comment) {
            $commentCollection[] = $this->buildModel((array)$comment);
        }
        return $commentCollection;
    }

    public function store(int $articleId, string $name, string $email, string $body)
    {
        $this->connection->getConnection()->insert(
            'comments',
            [
                'article_id' => $articleId,
                'username' => $name,
                'user_email' => $email,
                'comment_body' => $body
            ]);
        Cache::delete('comments_for_article_' . $articleId);
    }

    public function delete(int $articleId, int $commentId): void
    {
        $this->connection->getConnection()->delete('comments', ['id' => $commentId]);
        Cache::delete('comments_for_article_' . $articleId);
    }

    private function buildModel(array $commentReport): Comment
    {
        return new Comment(
            (int)$commentReport['article_id'],
            (int)$commentReport['id'],
            $commentReport['username'],
            $commentReport['user_email'],
            $commentReport['comment_body']
        );
    }
}