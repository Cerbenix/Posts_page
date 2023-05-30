<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;

interface ArticleRepository
{
    public function all(): array;
    public function getById(int $articleId): Article;
    public function getByUserId(int $userId): array;
    public function associateUsers(array $users, array $articles): array;
    public function save(Article $article): void;
    public function update(Article $article): void;
    public function delete(int $articleId):void;
}
