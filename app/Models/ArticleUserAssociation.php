<?php declare(strict_types=1);

namespace App\Models;

class ArticleUserAssociation
{
    private Article $article;
    private User $user;

    public function __construct(Article $article, User $user)
    {
        $this->article = $article;
        $this->user = $user;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
