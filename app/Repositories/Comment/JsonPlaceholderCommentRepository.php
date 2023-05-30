<?php declare(strict_types=1);

namespace App\Repositories\Comment;

use App\Cache;
use App\Models\Comment;
use GuzzleHttp\Client;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function getByArticleId(int $articleId): array
    {
        $commentCollection = [];
        $cacheKey = 'comments_for_article_' . $articleId;
        $report = $this->fetchFromApi('posts/' . $articleId . '/comments', $cacheKey);
        foreach ($report as $comment) {
            $commentCollection[] = $this->buildModel($comment);
        }
        return $commentCollection;
    }

    private function buildModel(\stdClass $commentReport): Comment
    {
        return new Comment(
            $commentReport->postId,
            $commentReport->id,
            $commentReport->name,
            $commentReport->email,
            $commentReport->body
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

    public function save(Comment $comment): void
    {

    }

    public function delete(int $commentId): void
    {

    }
}

