<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Models\Article;
use App\Models\User;

class ShowArticleResponse
{
    private Article $article;
    private User $user;
    private array $comments;

    public function __construct(Article $article, User $user, array $comments)
    {
        $this->article = $article;
        $this->user = $user;
        $this->comments = $comments;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}