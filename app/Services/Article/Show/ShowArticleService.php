<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Models\Comment;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Comment\CommentRepository;

use App\Repositories\User\UserRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository    $userRepository,
        CommentRepository $commentRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->articleRepository->getById($request->getArticleId());
        $userId = $article->getUserId();
        $user = $this->userRepository->getById($userId);
        $comments = $this->commentRepository->getByArticleId($request->getArticleId());
        return new ShowArticleResponse($article, $user, $comments);
    }
}
