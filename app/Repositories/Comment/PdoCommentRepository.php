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
        $comments = $this->queryBuilder->select('*')
            ->from('comments')
            ->where("article_id = $articleId")
            ->fetchAllAssociative();

        foreach ($comments as $comment) {
            $commentCollection[] = $this->buildModel((array)$comment);
        }
        return $commentCollection;
    }

    public function save(Comment $comment): void
    {
        $this->queryBuilder->insert('comments')
            ->values(
                [
                    'username' => '?',
                    'user_email' => '?',
                    'comment_body' => '?',
                    'article_id' => '?',
                ]
            )
            ->setParameter(0, $comment->getName())
            ->setParameter(1, $comment->getEmail())
            ->setParameter(2, $comment->getBody())
            ->setParameter(3, $comment->getPostId())
            ->executeQuery();
    }

    public function delete(int $commentId): void
    {
        $this->connection->getConnection()->delete('comments', ['id' => $commentId]);
    }

    private function buildModel(array $commentReport): Comment
    {
        return new Comment(
            (int)$commentReport['article_id'],
            $commentReport['username'],
            $commentReport['user_email'],
            $commentReport['comment_body'],
            (int)$commentReport['id']
        );
    }
}