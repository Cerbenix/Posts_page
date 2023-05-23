<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\User\JsonPlaceholderUserRepository;

class IndexArticleService
{
    private JsonPlaceholderArticleRepository $articleRepository;
    private JsonPlaceholderUserRepository $userRepository;

    public function __construct(
        JsonPlaceholderArticleRepository $articleRepository,
        JsonPlaceholderUserRepository $userRepository)
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
