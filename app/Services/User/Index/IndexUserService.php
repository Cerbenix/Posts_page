<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\User\UserRepository;

class IndexUserService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository    $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(IndexUserRequest $request): IndexUserResponse
    {
        $user = $this->userRepository->getById($request->getUserId());
        $userArticles = $this->articleRepository->getByUserId($request->getUserId());
        return new IndexUserResponse($user, $userArticles);
    }
}
