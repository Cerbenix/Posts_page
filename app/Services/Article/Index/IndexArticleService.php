<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\ArticleRepository;

use App\Repositories\User\UserRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(): IndexArticleResponse
    {
        $allArticles = $this->articleRepository->all();
        shuffle($allArticles);
        $articles = array_slice($allArticles, 0, 20);
        $users = $this->userRepository->all();
        $contents = $this->articleRepository->associateUser($users, $articles);
        return new IndexArticleResponse($contents);
    }
}
