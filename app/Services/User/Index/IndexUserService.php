<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\User\JsonPlaceholderUserRepository;

class IndexUserService
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

    public function execute(IndexUserRequest $request): IndexUserResponse
    {
        $user = $this->userRepository->getById($request->getUserId());
        $userArticles = $this->articleRepository->getByUserId($request->getUserId());
        return new IndexUserResponse($user, $userArticles);
    }
}
